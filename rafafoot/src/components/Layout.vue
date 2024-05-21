<script setup>
import {onMounted, reactive, ref} from 'vue'

const table = reactive({
  manager: '',
  time: '',
  times: [],
  campeonato: '',
  campeonatos: []
})

const teams = async () => {
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

onMounted(async () => {
    // await teams()
    await champs()
})

const selectedIdComputed = () => {
  const selectedId = table.times.find(item => item.name === table.time)
  table.time = selectedId.id
}
const salvar = async () => {

  const valores = {
      team_id: table.time,
      championship_id: table.campeonato,
      manager: table.manager,
  }
    const saveManager = await fetch('http://127.0.0.1:8000/api/treinadorAdd', {
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
              <p>Escolha a Divisão: </p>
              <v-row>
                <v-radio-group v-model="table.campeonato" v-for="champ in table.campeonatos" class="inline ">
                <v-col>
                  <v-radio :label="champ.name" :value="champ.id" @click="teams" ></v-radio>
                </v-col>
                </v-radio-group>
              </v-row>



            </div>

            <v-select :items="table.times" item-title="name" label="Equipe" v-model="table.time" >


            </v-select>
          </v-card-text>
          <v-card-actions>
            <v-btn color="primary" @click="salvar">Primary</v-btn>
            <v-btn color="secondary">Secondary</v-btn>
          </v-card-actions>
      </v-card>
    </v-main>
  </v-layout>
</template>

<style scoped lang="sass">

</style>
