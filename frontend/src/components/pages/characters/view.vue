<template>
  <div>
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <b-badge v-if="character.is_hero" pill variant="success">Игровой персонаж</b-badge>
        <b-badge v-else pill variant="secondary">Неигровой перснаж</b-badge>
      </div>
      <b-button v-if="['admin', 'root'].indexOf(user.can) !== -1" variant="primary"
                @click="goTo(`${$route.params.id_character}/edit`)">
        Редактировать
      </b-button>
    </div>

    <b-card class="mt-3 overflow-hidden" no-body style="max-width: 100%;">
      <b-row>
        <b-col md="7">
          <b-card-img v-if="character.large_photo_url" alt="Image" class="rounded-0" :src="character.large_photo_url"/>
        </b-col>
        <b-col md="5">
          <b-card-body>
            <h6 class="text-center text-secondary" v-if="character.form_of_appeal !== ''">
              {{ character.form_of_appeal }}
            </h6>
            <h4 class="text-center">{{ character.name }}</h4>
            <hr>
            <div>{{ labels.character.race }}: {{ character.race.name }}</div>
            <div v-if="character.height">{{ labels.character.height }}: {{ character.height }} см</div>
            <div v-if="character.dob">{{ labels.character.dob }}: {{ getDate(character.dob) }}</div>
            <div v-if="character.values !== ''">{{ labels.character.values }}: {{ character.values }}</div>
            <div v-if="character.favorite_food !== ''">
              {{ labels.character.favorite_food }}: {{ character.favorite_food }}
            </div>
            <div v-if="character.description">
              <hr>
              <div>{{ character.description }}</div>
            </div>
          </b-card-body>
        </b-col>
      </b-row>
    </b-card>

    <b-button v-if="['admin', 'root'].indexOf(user.can) !== -1" class="mt-3" v-b-modal.modal-add variant="primary">
      Добавить версию
    </b-button>
    <b-modal id="modal-add" ref="modal" title="Добавление версии" @hidden="resetModal" @show="resetModal">
      <form ref="form" @submit.stop.prevent="handleSubmit">
        <b-form-group :invalid-feedback="`«${labels.variation.class}» обязательное поле`" label-for="class-input"
                      :label="labels.variation.class" :state="classState">
          <b-form-select v-model="id_class" id="class-input" required>
            <b-form-select-option disabled :value="null">-- Пожалуйста выберите класс --</b-form-select-option>
            <b-form-select-option v-for="clas in classes" :key="`class-${clas.id}`" :value="clas.id">
              {{ clas.name }}
            </b-form-select-option>
          </b-form-select>
        </b-form-group>
        <b-form-group :invalid-feedback="`«${labels.variation.element}» обязательное поле`" label-for="element-input"
                      :label="labels.variation.element" :state="elementState">
          <b-form-select v-model="id_element" id="element-input" required>
            <b-form-select-option disabled :value="null">-- Пожалуйста выберите стихию --</b-form-select-option>
            <b-form-select-option v-for="element in elements" :key="`element-${element.id}`" :value="element.id">
              {{ element.name }}
            </b-form-select-option>
          </b-form-select>
        </b-form-group>
      </form>

      <template #modal-footer>
        <div class="w-100">
          <b-button class="float-right" size="sm" variant="success" @click="handleOk">Сохранить</b-button>
        </div>
      </template>
    </b-modal>

    <div>
      <div v-if="variations.length > 0">
        <b-card class="mt-3" v-for="variation in variations"
                :header="`${variation.element.name} - ${variation.class.name}`" :key="`variation-${variation.id}`"
                :style="`text-align: center; background-color: ${variation.element.color}`">
          <b-card-text>
            <b-card>
              <b-card-text class="d-flex justify-content-between align-items-end" v-for="comment in variation.comments"
                           :key="`variation-${variation.id}-comment-${comment.id}`">
                <span>{{ comment.user.name }}: {{ comment.comment }}</span>
                <small class="text-secondary">{{ getDateTime(comment.created_at) }}</small>
              </b-card-text>
              <b-card-text v-if="['admin', 'root', 'user'].indexOf(user.can) !== -1">
                <b-input-group>
                  <b-form-input placeholder="Комментарий" v-model="variation.new_comment"/>
                  <b-input-group-append>
                    <b-button variant="success" @click="createComment(variation.id, variation.new_comment)">
                      <b-icon-chevron-double-right/>
                    </b-button>
                  </b-input-group-append>
                </b-input-group>
              </b-card-text>
            </b-card>
          </b-card-text>
        </b-card>
      </div>
      <b-alert v-else class="mt-3 text-center" show variant="light">Нет записей для отображения</b-alert>
    </div>
  </div>
</template>

<script>
import {
  BAlert, BAvatar, BBadge, BButton, BCard, BCardBody, BCardGroup, BCardImg, BCardText, BCol, BFormGroup, BFormInput,
  BFormSelect, BFormSelectOption, BIconChevronDoubleRight, BInputGroup, BInputGroupAppend, BListGroup, BListGroupItem,
  BRow
} from "bootstrap-vue";
import {methods, users} from "../../mixins";
import Axios from "axios";

export default {
  async mounted() {
    await this.getUser();
    await this.getLabels();
    await this.getCharacter();
    await this.getClasses();
    await this.getElements();
    await this.getVariations();
  },
  components: {
    BAlert, BAvatar, BBadge, BButton, BCard, BCardBody, BCardGroup, BCardImg, BCardText, BCol, BFormGroup, BFormInput,
    BFormSelect, BFormSelectOption, BIconChevronDoubleRight, BInputGroup, BInputGroupAppend, BListGroup, BListGroupItem,
    BRow
  },
  data() {
    return {
      classes: [],
      classState: null,
      character: {},
      csrf: document.getElementsByName('csrf-token')[0].content,
      elements: [],
      elementState: null,
      id_class: null,
      id_element: null,
      labels: {
        character: {},
        variation: {}
      },
      variations: []
    }
  },
  methods: {
    async getClasses() {
      await Axios.get(`/api/classes`).then((res) => {
        this.classes = res.data;
      });
    },
    async getCharacter() {
      await Axios.get(`/api/characters/${this.$route.params.id_character}`).then((res) => {
        this.character = res.data.character;
        this.character.large_photo_url = res.data.large_photo_url;
        this.character.race = res.data.race;
      });
    },
    async getElements() {
      await Axios.get(`/api/elements`).then((res) => {
        this.elements = res.data;
      });
    },
    async getLabels() {
      await Axios.get(`/api/characters/labels`).then((res) => {
        this.labels.character = res.data;
      });
      await Axios.get(`/api/character-variations/labels`).then((res) => {
        this.labels.variation = res.data;
      });
    },
    async getVariations() {
      await Axios.get(`/api/characters/${this.$route.params.id_character}/variations`).then((res) => {
        this.variations = res.data;
      });
    },
    async createComment(id_variant, comment) {
      if (comment !== '') {
        const data = new FormData();
        data.append('comment', JSON.stringify(comment));
        await Axios.post(`/characters/${this.$route.params.id_character}/variations/${id_variant}/comments/create`, data, {
          headers: {'X-CSRF-Token': this.csrf}
        }).then(res => {
          if (res.data.success) {
            this.getVariations();
          } else {
            this.createToast(res.data.errors, 'Ошибка!', 'danger');
          }
        });
      }
    },
    async createVariation() {
      const data = new FormData();
      data.append('id_class', JSON.stringify(this.id_class));
      data.append('id_element', JSON.stringify(this.id_element));
      await Axios.post(`/characters/${this.$route.params.id_character}/variations/create`, data, {
        headers: {'X-CSRF-Token': this.csrf}
      }).then(res => {
        if (res.data.success) {
          this.getVariations();
        } else {
          this.createToast(res.data.errors, 'Ошибка!', 'danger');
        }
      });
    },
    checkFormValidity() {
      const valid = this.$refs.form.checkValidity();
      this.classState = (this.id_class !== null);
      this.elementState = (this.id_element !== null);
      return valid
    },
    handleOk(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault()
      // Trigger submit handler
      this.handleSubmit()
    },
    handleSubmit() {
      // Exit when the form isn't valid
      if (!this.checkFormValidity()) {
        return
      }
      // Push the name to submitted names
      this.createVariation();
      // Hide the modal manually
      this.$nextTick(() => {
        this.$bvModal.hide('modal-add')
      })
    },
    resetModal() {
      this.classState = null;
      this.elementState = null;
      this.id_class = null;
      this.id_element = null;
    }
  },
  mixins: [methods, users]
}
</script>