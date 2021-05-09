<template>
  <div>
    <b-button v-if="['admin', 'root'].indexOf(user.can) !== -1" v-b-modal.modal-add variant="primary">Добавить стихию
    </b-button>

    <b-modal id="modal-add" ref="modal" title="Добавление стихии" @hidden="resetModal" @show="resetModal">
      <form ref="form" @submit.stop.prevent="handleSubmit">
        <b-form-group :invalid-feedback="`«${labels.name}» обязательное поле`" label-for="name-input"
                      :label="labels.name" :state="nameState">
          <b-form-input v-model="name" id="name-input" required :state="nameState"/>
        </b-form-group>
        <b-form-group :invalid-feedback="`«${labels.color}» обязательное поле`" label-for="name-input"
                      :label="labels.color" :state="colorState">
          <b-form-input v-model="color" id="color-input" required type="color" :state="colorState"/>
        </b-form-group>
      </form>

      <template #modal-footer>
        <div class="w-100">
          <b-button class="float-right" size="sm" variant="success" @click="handleOk">Сохранить</b-button>
        </div>
      </template>
    </b-modal>

    <div class="mt-3">
      <b-card-group v-if="elements.length > 0" columns>
        <b-card v-for="element in elements" :key="`element-${element.id}`">
          <b-card-text class="d-flex justify-content-between align-items-center">
            <span>{{ element.name }}</span>
            <b-icon-circle-fill font-scale="2" :style="`color: ${element.color};`"/>
          </b-card-text>
        </b-card>
      </b-card-group>
      <b-alert v-else class="text-center" show variant="light">Нет записей для отображения</b-alert>
    </div>
  </div>
</template>

<script>
import {
  BAlert, BButton, BCard, BCardGroup, BCardText, BFormGroup, BFormInput, BIconCircleFill, BModal
} from "bootstrap-vue";
import {methods, users} from "../../mixins";
import Axios from "axios";

export default {
  async mounted() {
    await this.getUser();
    await this.getLabels();
    await this.getElements();
  },
  components: {BAlert, BButton, BCard, BCardGroup, BCardText, BFormGroup, BFormInput, BIconCircleFill, BModal},
  data() {
    return {
      color: null,
      colorState: null,
      csrf: document.getElementsByName('csrf-token')[0].content,
      elements: [],
      labels: {},
      name: '',
      nameState: null,
      submittedNames: []
    }
  },
  methods: {
    async createElement() {
      const data = new FormData();
      data.append('name', JSON.stringify(this.name));
      data.append('color', JSON.stringify(this.color));
      await Axios.post('/elements/create', data, {
        headers: {'X-CSRF-Token': this.csrf}
      }).then(res => {
        if (res.data.success) {
          this.getElements();
        } else {
          this.createToast(res.data.errors, 'Ошибка!', 'danger');
        }
      });
    },
    async getLabels() {
      await Axios.get(`/api/elements/labels`).then((res) => {
        this.labels = res.data;
      });
    },
    async getElements() {
      await Axios.get(`/api/elements`).then((res) => {
        this.elements = res.data;
      });
    },
    checkFormValidity() {
      const valid = this.$refs.form.checkValidity();
      this.nameState = (this.name !== '');
      this.colorState = (this.color !== null);
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
      this.createElement();
      // Hide the modal manually
      this.$nextTick(() => {
        this.$bvModal.hide('modal-add')
      })
    },
    resetModal() {
      this.color = null;
      this.colorState = null;
      this.name = '';
      this.nameState = null;
    }
  },
  mixins: [methods, users]
}
</script>