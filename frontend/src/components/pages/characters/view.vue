<template>
  <div>
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <b-badge v-if="character.is_hero" pill variant="success">Игровой персонаж</b-badge>
        <b-badge v-else pill variant="secondary">Неигровой перснаж</b-badge>
      </div>
      <b-button variant="primary" @click="goTo(`${$route.params.id_character}/edit`)">Редактировать</b-button>
    </div>

    <b-card class="overflow-hidden" no-body style="max-width: 100%;">
      <b-row>
        <b-col md="7">
          <b-card-img alt="Image" class="rounded-0" :src="character.large_photo_url"/>
        </b-col>
        <b-col md="5">
          <b-card-body>
            <h6 class="text-center text-secondary">{{ character.form_of_appeal }}</h6>
            <h4 class="text-center">{{ character.name }}</h4>
            <hr>
            <div>{{ labels.race }}: {{ character.race.name }}</div>
            <div>{{ labels.height }}: {{ character.height }} см</div>
            <div>{{ labels.dob }}: {{ getDate(character.dob) }}</div>
            <div>{{ labels.values }}: {{ character.values }}</div>
            <div>{{ labels.favorite_food }}: {{ character.favorite_food }}</div>
            <hr>
            <div>{{ character.description }}</div>
          </b-card-body>
        </b-col>
      </b-row>
    </b-card>
  </div>
</template>

<script>
import {
  BAlert, BAvatar, BBadge, BButton, BCard, BCardBody, BCardImg, BCardText, BCol, BListGroup, BListGroupItem, BRow
} from "bootstrap-vue";
import {methods} from "../../mixins";
import Axios from "axios";

export default {
  async mounted() {
    await this.getLabels();
    await this.getCharacter();
  },
  components: {
    BAlert, BAvatar, BBadge, BButton, BCard, BCardBody, BCardImg, BCardText, BCol, BListGroup, BListGroupItem, BRow
  },
  data() {
    return {
      character: {},
      labels: {}
    }
  },
  methods: {
    async getCharacter() {
      await Axios.get(`/api/characters/${this.$route.params.id_character}`).then((res) => {
        this.character = res.data.character;
        this.character.large_photo_url = res.data.large_photo_url;
        this.character.race = res.data.race;
      });
    },
    async getLabels() {
      await Axios.get(`/api/characters/labels`).then((res) => {
        this.labels = res.data;
      });
    }
  },
  mixins: [methods]
}
</script>