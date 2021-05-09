<template>
  <div>
    <b-button v-if="['admin', 'root'].indexOf(user.can) !== -1" @click="goTo('characters/add')">
      Добавить героя
    </b-button>

    <div class="mt-3">
      <b-card-group v-if="characters.length > 0" columns>
        <b-card v-for="character in characters" style="cursor: pointer" :key="`character-${character.id}`"
                @click="goTo(`characters/${character.id}`)">
          <b-card-text class="d-flex justify-content-between align-items-center">
            <span>{{ character.name }}</span>
            <b-avatar variant="primary" :text="character.name[0]"/>
          </b-card-text>
        </b-card>
      </b-card-group>
      <b-alert v-else class="text-center" show variant="light">Нет записей для отображения</b-alert>
    </div>
  </div>
</template>

<script>
import {BAlert, BAvatar, BButton, BCard, BCardGroup, BCardText} from "bootstrap-vue";
import {methods, users} from "../../mixins";
import Axios from "axios";

export default {
  async mounted() {
    await this.getUser();
    await this.getCharacters();
  },
  components: {BAlert, BAvatar, BButton, BCard, BCardGroup, BCardText},
  data() {
    return {
      characters: []
    }
  },
  methods: {
    async getCharacters() {
      await Axios.get(`/api/characters`).then((res) => {
        this.characters = res.data;
      });
    }
  },
  mixins: [methods, users]
}
</script>