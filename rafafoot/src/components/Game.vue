<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const roundResults = ref({});
const headers = [
  { text: 'Público', value: 'audience' },
  { text: 'Equipe da Casa', value: 'home_team' },
  { text: 'Gols Casa', value: 'home_goals' },
  { text: 'X', value: 'vs' },
  { text: 'Gols Visitante', value: 'away_goals' },
  { text: 'Equipe Visitante', value: 'away_team' },
];


const results = async () => {
    const response = await axios.get('http://localhost:8000/api/process-round');
    roundResults.value = response.data;
    // roundResults.value.forEach(item => {
    //   console.log(item);
    // });

    // console.log(roundResults.value);
}

const homeGoals = ref(0);
const awayGoals = ref(0);

const updateGoals = async () => {

};


onMounted(async () => {
    await results();
    await updateGoals();
});
</script>

<template>
  <v-container>
    <div><p>Tempo decorrido: {{ tempoDecorrido }} segundos</p></div>
    <v-row>
      <v-col v-for="(data, division) in roundResults" :key="division" cols="12" md="6">
        <v-card>
          <v-card-title>{{ division }}</v-card-title>
          <v-divider></v-divider>
          <v-card-text>
            <v-table>
              <thead>
              <!-- <tr>
                  <th v-for="header in headers" :key="header.text">{{ header.text }}</th>
              </tr> -->
              </thead>
              <tbody>
                <tr v-for="item in data" :key="item.division"  :class="item.home_goals > item.away_goals? 'green--text' :'red--text'">
                  <td>{{item.audience}}</td>
                  <td>{{item.home_team}}</td>
                  <td>{{item.events.home_goals}}</td>
                  <td> X </td>
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
