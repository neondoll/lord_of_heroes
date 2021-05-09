<template>
  <div>
    <b-button v-if="['admin', 'root'].indexOf(user.can) !== -1" v-b-modal.modal-add variant="primary">
      Добавить расу
    </b-button>

    <b-modal id="modal-add" ref="modal" title="Добавление расы" @hidden="resetModal" @show="resetModal">
      <form ref="form" @submit.stop.prevent="handleSubmit">
        <b-form-group :invalid-feedback="`«${labels.name}» обязательное поле`" label-for="name-input"
                      :label="labels.name" :state="nameState">
          <b-form-input id="name-input" required v-model="name" :state="nameState"/>
        </b-form-group>
      </form>

      <template #modal-footer>
        <div class="w-100">
          <b-button class="float-right" size="sm" variant="success" @click="handleOk">Сохранить</b-button>
        </div>
      </template>
    </b-modal>

    <div class="mt-3">
      <b-list-group v-if="races.length > 0">
        <b-list-group-item v-for="race in races" href="#some-link" :key="`race-${race.id}`">
          {{ race.name }}
        </b-list-group-item>
      </b-list-group>
      <b-alert v-else class="text-center" show variant="light">Нет записей для отображения</b-alert>
    </div>
  </div>
</template>

<script>
import {BAlert, BButton, BFormGroup, BFormInput, BListGroup, BListGroupItem, BModal} from "bootstrap-vue";
import {methods, users} from "../../mixins";
import Axios from "axios";

export default {
  async mounted() {
    await this.getUser();
    await this.getLabels();
    await this.getRaces();
  },
  components: {BAlert, BButton, BFormGroup, BFormInput, BListGroup, BListGroupItem, BModal},
  data() {
    return {
      csrf: document.getElementsByName('csrf-token')[0].content,
      labels: {},
      name: '',
      nameState: null,
      races: [],
      submittedNames: []
    }
  },
  methods: {
    async createRace() {
      const data = new FormData();
      data.append('name', JSON.stringify(this.name));
      await Axios.post('/races/create', data, {
        headers: {'X-CSRF-Token': this.csrf}
      }).then(res => {
        if (res.data.success) {
          this.getRaces();
        } else {
          this.createToast(res.data.errors, 'Ошибка!', 'danger');
        }
      });
    },
    async getLabels() {
      await Axios.get(`/api/races/labels`).then((res) => {
        this.labels = res.data;
      });
    },
    async getRaces() {
      await Axios.get(`/api/races`).then((res) => {
        this.races = res.data;
      });
    },
    checkFormValidity() {
      const valid = this.$refs.form.checkValidity()
      this.nameState = valid
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
      this.createRace();
      // Hide the modal manually
      this.$nextTick(() => {
        this.$bvModal.hide('modal-add')
      })
    },
    resetModal() {
      this.name = ''
      this.nameState = null
    }
  },
  mixins: [methods, users]
}
</script>