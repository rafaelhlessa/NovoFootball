<script setup>
import {onMounted, reactive, ref} from 'vue';
import axios from "axios";

const table = reactive({
  manager: '',
  time: '',
  times: [],
  campeonato: '',
  campeonatos: []
})

const team = async () => {
  table.time = '';
  table.times = [];
  const response = await fetch('http://127.0.0.1:8000/api/time/')
  const data = await response.json()

  data.data.map(item => {
    if (item.championship_id === table.campeonato) {
      table.times.push({id: item.id, name: item.name})
    }
  })
console.log(table.times)
}

const champs = async () => {
  const response = await fetch('http://127.0.0.1:8000/api/campeonato/')
  const data = await response.json()

  table.campeonatos = data.data;

}

const selectedIdComputed = () => {
  const selectedId = table.times.find(item => item.name === table.time)
  table.time = selectedId.id
}
const salvar = async () => {

  const valores = {
      // team_id: table.time,
      // championship_id: table.campeonato,
      manager: table.manager,
  }

  console.log(valores);
    const saveManager = await axios('http://127.0.0.1:8000/api/treinadorAdd', {
        method: 'POST',
        body: JSON.stringify(valores.manager),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    // const response = await fetch('http://127.0.0.1:8000/api/time/', {
    //     method: 'POST',
    //     body: JSON.stringify({
    //         name: table.time,
    //         championship_id: table.campeonato
    //     }),
    //     headers: {
    //         'Content-Type': 'application/json'
    //     }
    // })
    // const data = await response.json()
    console.log(valores)
}

const showTeams = ref(true);
const teams = ref([]);
const selectedTeamName = ref('');

// Função para buscar as equipes com championship_id === 4
const fetchTeams = async () => {
  try {
    const response = await fetch('http://127.0.0.1:8000/api/time/');
    const data = await response.json();

    teams.value = data.data;
    await new Promise(resolve => setTimeout(resolve, 2000)); // Espera 2 segundos
    showTeams.value = false;
    // Sortear uma equipe
    const randomIndex = Math.floor(Math.random() * teams.value.length);
    console.log(teams.value)
    selectedTeamName.value = teams.value[randomIndex].name;
  } catch (error) {
    console.error('Erro ao buscar equipes:', error);
  }
};

onMounted(() => {

  champs();
});


</script>

<template>
  <v-layout class="rounded rounded-md">
    <v-app-bar color="surface-variant" title="Rafa Football"></v-app-bar>

    <v-navigation-drawer>
      <v-list>
        <v-list-item title="Drawer left"></v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-navigation-drawer location="right">
      <v-list>
        <v-list-item title="Drawer right"></v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-main class="d-flex align-center justify-center" style="min-height: 300px;">
      <v-card class="mt-4 w-50">
          <v-card-title class="mb-8">Rafa Football</v-card-title>
          <v-card-text>
            <v-text-field label="Nome Treinador" variant="outlined" v-model="table.manager" class="my-4"></v-text-field>
            <div class="my-4">
              <div v-if="showTeams">
                <div v-for="team in teams" :key="team.id">
                  {{ team.name }}
                </div>
              </div>
              <div v-else>
                <transition name="fade">
                  <div>{{ selectedTeamName }}</div>
                </transition>
              </div>
            </div>
          </v-card-text>
          <v-card-actions>
            <v-btn color="primary" @click="fetchTeams">Primary</v-btn>
            <v-btn color="secondary" @click="salvar">Secondary</v-btn>
          </v-card-actions>
      </v-card>
    </v-main>
  </v-layout>
</template>

<style scoped lang="sass">
//.fade-enter-active, .fade-leave-active {
//  transition: opacity 2s;
//}
//.fade-enter, .fade-leave-to {
//  opacity: 0;
//}
</style>
