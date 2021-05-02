<template>
  <div>
    <h3>Добавление героя</h3>
    <b-form v-if="show" @reset="onReset" @submit="onSubmit">
      <b-row>
        <b-col>
          <b-form-group id="input-group-1" label-for="input-1" :label="`${labels.form_of_appeal}:`">
            <b-form-input v-model="form.form_of_appeal" id="input-1" placeholder="Введите форму обращения" required/>
          </b-form-group>
        </b-col>
        <b-col>
          <b-form-group id="input-group-2" label-for="input-2" :label="`${labels.name}:`">
            <b-form-input v-model="form.name" id="input-2" placeholder="Введите имя" required/>
          </b-form-group>
        </b-col>
      </b-row>

      <b-row>
        <b-col>
          <b-form-group id="input-group-3" label-for="input-3" :label="`${labels.race}:`">
            <b-form-select v-model="form.id_race" id="input-3" required>
              <b-form-select-option disabled :value="null">-- Пожалуйста выберите расу --</b-form-select-option>
              <b-form-select-option v-for="race in races" :key="`race-${race.id}`" :value="race.id">
                {{ race.name }}
              </b-form-select-option>
            </b-form-select>
          </b-form-group>
        </b-col>
        <b-col>
          <b-form-group id="input-group-5" label-for="input-5" :label="`${labels.height}:`">
            <b-input-group append="см">
              <b-form-input v-model="form.height" id="input-5" min="0" placeholder="Введите рост" required
                            type="number"/>
            </b-input-group>
          </b-form-group>
        </b-col>
        <b-col>
          <b-form-group id="input-group-4" label-for="input-4" :label="`${labels.dob}:`">
            <b-form-input v-model="form.dob" id="input-4" required type="date"/>
          </b-form-group>
        </b-col>
      </b-row>

      <b-row>
        <b-col>
          <b-form-group id="input-group-6" label-for="input-6" :label="`${labels.values}:`">
            <b-form-input v-model="form.values" id="input-6" placeholder="Введите ценности" required/>
          </b-form-group>
        </b-col>
        <b-col>
          <b-form-group id="input-group-7" label-for="input-7" :label="`${labels.favorite_food}:`">
            <b-form-input v-model="form.favorite_food" id="input-7" placeholder="Введите любимую еду" required/>
          </b-form-group>
        </b-col>
      </b-row>

      <b-form-group id="input-group-8" label-for="input-8" :label="`${labels.description}:`">
        <b-form-textarea v-model="form.description" id="input-8" max-rows="6" placeholder="Введите описание" required
                         rows="3"/>
      </b-form-group>

      <b-form-group id="input-group-9" v-slot="{ ariaDescribedby }">
        <b-form-checkbox v-model="form.is_hero" id="input-9" switch :aria-describedby="ariaDescribedby">
          {{ labels.is_hero }}
        </b-form-checkbox>
      </b-form-group>

      <b-button type="submit" variant="success">Сохранить</b-button>
      <b-button type="reset" variant="danger">Отмена</b-button>
    </b-form>
  </div>
</template>

<script>
import Axios from 'axios';
import {
  BButton, BCol, BForm, BFormCheckbox, BFormCheckboxGroup, BFormGroup, BFormInput, BFormSelect, BFormSelectOption,
  BFormTextarea, BInputGroup, BRow
} from "bootstrap-vue";
import {methods} from "../../mixins";

export default {
  async mounted() {
    await this.getLabels();
    await this.getRaces();
    this.show = true;
  },
  components: {
    BButton, BCol, BForm, BFormCheckbox, BFormCheckboxGroup, BFormGroup, BFormInput, BFormSelect, BFormSelectOption,
    BFormTextarea, BInputGroup, BRow
  },
  data() {
    return {
      csrf: document.getElementsByName('csrf-token')[0].content,
      form: {
        dob: null,
        favorite_food: '',
        form_of_appeal: '',
        height: null,
        id_race: null,
        is_hero: false,
        name: '',
        values: ''
      },
      labels: {},
      races: [],
      show: false
    }
  },
  methods: {
    async getLabels() {
      await Axios.get(`/api/characters/labels`).then((res) => {
        this.labels = res.data;
      });
    },
    async getRaces() {
      await Axios.get(`/api/races`).then((res) => {
        this.races = res.data;
      });
    },
    async onSubmit(event) {
      event.preventDefault()

      const data = new FormData();
      data.append('character', JSON.stringify(this.form));
      await Axios.post('/characters/create', data, {headers: {'X-CSRF-Token': this.csrf}}).then(res => {
        if (res.data.success) {
          this.goTo(`/characters/${res.data.id}`);
        } else {
          this.createToast(res.data.errors, 'Ошибка!', 'danger');
        }
      });
    },
    onReset(event) {
      event.preventDefault()
      this.goTo('/characters');
    }
  },
  mixins: [methods]
}
</script>