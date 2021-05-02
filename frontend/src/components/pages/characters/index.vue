<template>
  <div>
    <b-button @click="goTo('characters/add')">Добавить героя</b-button>

    <div class="mt-3">
      <b-list-group v-if="characters.length > 0">
        <b-list-group-item v-for="(character, i) in characters" style="cursor: pointer"
                           :key="`character-${character.id}`" @click="goTo(`characters/${character.id}`)">
          <div
              :class="`d-flex flex-row${(i % 2 === 1) ? '-reverse' : null} justify-content-between align-items-center`">
            <div>{{ character.name }}</div>
            <b-avatar variant="primary" :text="character.name[0]"/>
          </div>
        </b-list-group-item>
      </b-list-group>
      <b-alert v-else class="text-center" show variant="light">Нет записей для отображения</b-alert>
    </div>
  </div>
</template>

<script>
import {BAlert, BAvatar, BButton, BListGroup, BListGroupItem} from "bootstrap-vue";
import {methods} from "../../mixins";
import Axios from "axios";

export default {
  async mounted() {
    await this.getCharacters();
  },
  components: {BAlert, BAvatar, BButton, BListGroup, BListGroupItem},
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
  mixins: [methods]
}
</script>