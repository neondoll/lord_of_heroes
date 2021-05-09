<template>
  <div>
    <h3>Добавление героя</h3>
    <character-form class="mt-2" :reset="'/characters'"/>
  </div>
</template>

<script>
import CharacterForm from "../../organisms/CharacterForm";

export default {
  components: {CharacterForm}
}
</script>
