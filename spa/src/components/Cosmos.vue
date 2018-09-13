<template>
  <div class="home">
    <h2 class="center">{{ data.title }}</h2>
    <div v-if="data.media_type == 'video'">
      <iframe width="600" height="338" frameborder="0" :src="data.url" allowfullscreen></iframe>
    </div>
    <div v-else>
      <img width="600" :src="data.url" />
      <p v-show="data.copyright">&copy; {{ data.copyright }}</p>
    </div>
    <p>{{ data.explanation }}</p>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Cosmos',

  data () {
    return {
      data: {}
    }
  },

  mounted () {
    axios.post('/api/apod').then(response => {
      this.data = response.data
    })    
  }
}
</script>