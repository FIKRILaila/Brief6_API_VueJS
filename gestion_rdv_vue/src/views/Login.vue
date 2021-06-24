<template>
  <div class="container">
    <form @submit="Login">
          <div class="groupe" >
            <label>Email</label>
            <input type="email" placeholder="Your email"  v-model="email">
          </div>
          <div class="groupe" >
            <label>Password</label>
            <input type="password" placeholder="password" v-model="password">
          </div>
          <button type="submit">Login</button>
      </form>
  </div> 
</template>

<script>
export default{
    name:"Login",
    data(){
        return{
            email:'',
            password:'',
        }
    },
    beforeMount(){
      this.logout()
    },
    methods:{
      logout(){
        localStorage.removeItem('user')
        localStorage.removeItem('token')
      },
    async Login(e){
        e.preventDefault();
        let user = {
                email: this.email,
                password: this.password,
                }
               var myHeaders = new Headers();
                      myHeaders.append("Content-Type", "application/json");

        const res = await fetch('http://localhost/Gestion_RDV_Vue3_API/app/Patient/login',{
            method: 'POST',
            headers: myHeaders,
            body: JSON.stringify(user)
            })
            const result = await res.json()
            localStorage.setItem("Token", result.Token)
            localStorage.setItem("user", JSON.stringify(result.User))
            window.location.replace("/")
            return result
    }
    }
}
</script>
<style scoped lang="scss">
  .container{
    width: 30%;
    margin-left: 35%;
    form{
      display: flex;
      flex-direction: column;
      width:100%;
      border-radius: 5px;
      background-color: #E8F0FE;
      padding: 20px;
      .groupe{
          display: flex;
          flex-direction: column;
          align-items: start;
          width: 100%;
          label{
            margin:30px 0 10px 0;
            font-weight: 600;
            color:rgb(9, 9, 83);
          }
          input{
            outline: none;
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
          }
      }
      button{
        width: 100%;
        font-weight: 700;
        font-size: 20px;
        background-color:rgb(9, 9, 83);
        color: white;
        padding: 14px 20px;
        margin:50px 0 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
      }
      }
}


</style>
