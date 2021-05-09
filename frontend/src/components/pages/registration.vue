<template>
  <div>
    <h1>Регистрация</h1>

    <b-form v-if="show" @reset="onReset" @submit="onSubmit">
      <b-form-group id="input-group-1" label-for="input-1" label="Имя:">
        <b-form-input v-model="form.name" id="input-1" placeholder="Введите имя" required/>
      </b-form-group>

      <b-form-group id="input-group-2" label-for="input-2" label="Логин:">
        <b-form-input v-model="form.username" id="input-2" placeholder="Введите логин" required/>
      </b-form-group>

      <b-form-group id="input-group-3" label-for="input-3" label="`Почта:`">
        <b-form-input v-model="form.email" id="input-3" placeholder="Введите почту" required type="email"/>
      </b-form-group>

      <b-form-group id="input-group-4" label-for="input-4" label="Пароль:">
        <b-input-group>
          <b-form-input v-model="form.password" id="input-4" placeholder="Введите пароль" required
                        :state="form.password === ''? null : (form.password.length > 7)"
                        :type="eye_password ? 'password' : 'text'"/>
          <b-input-group-append>
            <b-button variant="outline-seconder" @click="eye_password = !eye_password">
              <b-icon-eye-fill v-if="eye_password"/>
              <b-icon-eye-slash-fill v-else/>
            </b-button>
          </b-input-group-append>
        </b-input-group>
      </b-form-group>

      <b-form-group id="input-group-5" label-for="input-5" label="Повторите пароль:">
        <b-input-group>
          <b-form-input v-model="form.password_reset" id="input-5" placeholder="Повторите пароль" required
                        :state="form.password_reset === ''? null : (form.password === form.password_reset)"
                        :type="eye_password_reset ? 'password' : 'text'"/>
          <b-input-group-append>
            <b-button variant="outline-seconder" @click="eye_password_reset = !eye_password_reset">
              <b-icon-eye-fill v-if="eye_password_reset"/>
              <b-icon-eye-slash-fill v-else/>
            </b-button>
          </b-input-group-append>
        </b-input-group>
      </b-form-group>

      <b-button type="submit" variant="success">Зарегистрироваться</b-button>
      <b-button type="reset" variant="primary">Войти</b-button>
    </b-form>
  </div>
</template>

<script>
import Axios from "axios";
import {
  BButton, BForm, BFormGroup, BFormInput, BFormSelect, BIconEyeFill, BIconEyeSlashFill, BInputGroup, BInputGroupAppend
} from "bootstrap-vue";
import {methods} from "../mixins";

export default {
  async mounted() {
    this.show = true;
  },
  components: {
    BButton, BForm, BFormGroup, BFormInput, BFormSelect, BIconEyeFill, BIconEyeSlashFill, BInputGroup, BInputGroupAppend
  },
  data() {
    return {
      csrf: document.getElementsByName("csrf-token")[0].content,
      eye_password: true,
      eye_password_reset: true,
      form: {
        email: '',
        name: '',
        password: '',
        password_reset: '',
        username: ''
      },
      show: false
    }
  },
  methods: {
    async onSubmit(event) {
      event.preventDefault()

      if (this.form.password.length > 7 && this.form.password === this.form.password_reset) {
        const data = new FormData();
        data.append('user', JSON.stringify(this.form));
        await Axios.post('/site/create-user', data, {
          headers: {'X-CSRF-Token': this.csrf}
        }).then(res => {
          if (res.data.success) {
            this.goTo('/site/login');
          } else {
            this.createToast(res.data.errors, 'Ошибка!', 'danger');
          }
        });
      }
    },
    onReset(event) {
      event.preventDefault()
      this.goTo('/site/login');
    }
  },
  mixins: [methods]
}
</script>