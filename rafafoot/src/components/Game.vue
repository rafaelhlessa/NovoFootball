<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const divisions = [
  {name: 'Divisão 1', serie: 1},
  {name: 'Divisão 2', serie: 2},
  {name: 'Divisão 3', serie: 3},
  {name: 'Divisão 4', serie: 4}
];

const roundResults = ref({});
const headers = [
  { text: 'Público', value: 'audience' },
  { text: 'Equipe da Casa', value: 'home_team' },
  { text: 'Gols Casa', value: 'home_goals' },
  { text: 'X', value: 'vs' },
  { text: 'Gols Visitante', value: 'away_goals' },
  { text: 'Equipe Visitante', value: 'away_team' },
];

const serie = ref([]);
const results = async () => {
    const response = await axios.get('http://localhost:8000/api/process-round');
    roundResults.value = response.data;
    roundResults.value.forEach(item => {
        if (item.serie === divisions.serie) {
            serie.value = item.division;
        }
    });
}

onMounted(async () => {
    await results();
});
</script>

<template>
  <v-container>
    <v-row>
      <v-col v-for="division in divisions" :key="division" cols="12" md="6">
        <v-card>
          <v-card-title>{{ division.name }}</v-card-title>
          <v-card-text>
            <v-table>
              <thead>
              <tr>
                  <th v-for="header in headers" :key="header.text">{{ header.text }}</th>
              </tr>
              </thead>
              <tbody v-for="item in roundResults" :key="item.division">
              <tr :class="item.home_goals > item.away_goals? 'green--text' :'red--text'">
                  <td>{{item.audience}}</td>
                  <td>{{item.home_team}}</td>
                  <td>{{item.events.home_goals}}</td>
                  <td> x </td>
                  <td>{{item.events.away_goals}}</td>
                  <td>{{item.away_team}}</td>
              </tr>
              </tbody>
            </v-table>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<style scoped lang="sass">

</style>
