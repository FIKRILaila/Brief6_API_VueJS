<template>
  <div id="nav" v-if="log">
    <router-link  to="/Login">Login</router-link>
    <router-link  to="/Register">Register</router-link>
  </div>
   <div id="nav" v-else>
    <router-link  to="/">Home</router-link>
    <router-link to="/mesRDVs">Mes RDVs </router-link>
    <button @click="logout">logout</button>
  </div>
  <router-view/>
</template>

<script>
  export default {
    data(){
      return{
        log : true
      }
    },
    methods:{
      logout(){
            localStorage.removeItem('User')
            localStorage.removeItem('Token')
            window.location.replace("/Login")
        },
    logged(){
      let user = localStorage.getItem('user')
      if(user){
            this.log = false
      }else{
         this.log = true
         $route.push("/Login")
      }
    }
  },
  mounted(){
    this.logged()
  }
  }
</script>
<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#nav {
  padding: 50px;
  width: 30%;
  margin-left: 35%;
  a {
    font-weight: bold;
    color: #2c3e50;
    text-decoration: none;
    margin-right:20px;

    &.router-link-exact-active{
      color: #42b983;
    }
  }
}
</style>
