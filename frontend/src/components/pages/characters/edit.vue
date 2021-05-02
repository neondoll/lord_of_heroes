<template>
  <div v-if="show">
    <h3 class="mt-2">Редактирование героя</h3>
    <character-form class="mt-2" :form="character" :reset="`/characters/${$route.params.id_character}`"/>
  </div>
</template>

<script>
import Axios from 'axios';
import CharacterForm from "../../organisms/CharacterForm";

export default {
  async mounted() {
    await this.getCharacter();
    this.show = true;
  },
  components: {CharacterForm},
  data() {
    return {
      character: {},
      show: false
    }
  },
  methods: {
    async getCharacter() {
      await Axios.get(`/api/characters/${this.$route.params.id_character}`).then((res) => {
        this.character = res.data.character;
        this.character.is_hero = Boolean(this.character.is_hero);
      });
    }
  }
}
</script>
