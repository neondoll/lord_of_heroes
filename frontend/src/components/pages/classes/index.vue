<template>
  <div>
    <b-button v-if="['admin', 'root'].indexOf(user.can) !== -1" v-b-modal.modal-add variant="primary">
      Добавить класс
    </b-button>

    <b-modal id="modal-add" ref="modal" title="Добавление класса" @hidden="resetModal" @show="resetModal">
      <form ref="form" @submit.stop.prevent="handleSubmit">
        <b-form-group :invalid-feedback="`«${labels.name}» обязательное поле`" label-for="name-input"
                      :label="labels.name" :state="nameState">
          <b-form-input v-model="name" id="name-input" required :state="nameState"/>
        </b-form-group>
      </form>

      <template #modal-footer>
        <div class="w-100">
          <b-button class="float-right" size="sm" variant="success" @click="handleOk">Сохранить</b-button>
        </div>
      </template>
    </b-modal>

    <div class="mt-3">
      <b-card-group v-if="classes.length > 0" columns>
        <b-card v-for="clas in classes" :key="`class-${clas.id}`">
          <b-card-text>{{ clas.name }}</b-card-text>
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
    await this.getClasses();
  },
  components: {BAlert, BButton, BCard, BCardGroup, BCardText, BFormGroup, BFormInput, BIconCircleFill, BModal},
  data() {
    return {
      csrf: document.getElementsByName('csrf-token')[0].content,
      classes: [],
      labels: {},
      name: '',
      nameState: null,
      submittedNames: []
    }
  },
  methods: {
    async createClass() {
      const data = new FormData();
      data.append('name', JSON.stringify(this.name));
      await Axios.post('/classes/create', data, {
        headers: {'X-CSRF-Token': this.csrf}
      }).then(res => {
        if (res.data.success) {
          this.getClasses();
        } else {
          this.createToast(res.data.errors, 'Ошибка!', 'danger');
        }
      });
    },
    async getClasses() {
      await Axios.get(`/api/classes`).then((res) => {
        this.classes = res.data;
      });
    },
    async getLabels() {
      await Axios.get(`/api/classes/labels`).then((res) => {
        this.labels = res.data;
      });
    },
    checkFormValidity() {
      const valid = this.$refs.form.checkValidity();
      this.nameState = valid;
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
      this.createClass();
      // Hide the modal manually
      this.$nextTick(() => {
        this.$bvModal.hide('modal-add')
      })
    },
    resetModal() {
      this.name = '';
      this.nameState = null;
    }
  },
  mixins: [methods, users]
}
</script>