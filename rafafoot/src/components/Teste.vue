<script setup>
import { ref, onMounted } from 'vue';



const value = 12345;
const currentValue = ref('');
const countdown = ref('');
const showValue = ref(false);
const showCountdown = ref(false);

const startIteration = () => {
  showValue.value = true;
  const valueStr = value.toString();
  let index = 0;
  const intervalId = setInterval(() => {
    if (index >= valueStr.length) {
      clearInterval(intervalId);
      showCountdown.value = false;
      return;
    }
    currentValue.value += valueStr[index];
    index++;
  }, Math.floor(Math.random() * 4000) + 1000);
};

const startCountdown = () => {
  showCountdown.value = true;
  let count = value;
  const intervalId = setInterval(() => {
    if (count <= 0) {
      clearInterval(intervalId);
      showValue.value = false;
      return;
    }
    countdown.value = count;
    count--;
  }, Math.floor(Math.random() * 5000) + 1000);
};


onMounted(() => {
  startIteration();
  setTimeout(() => {
    startCountdown();
  }, value * 1000); // Aguarda o tempo total do valor para iniciar a contagem regressiva
});
</script>

<template>
<div>
    <p v-if="showValue">{{ currentValue }}</p>
    <p>Contagem regressiva:</p>
    <p v-if="showCountdown">{{ countdown }}</p>
  </div>
</template>
