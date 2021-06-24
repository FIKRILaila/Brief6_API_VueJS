<template>
  <div class="container">
    <form @submit="Register">
        <div class="groupe">
          <label>Nom</label>
          <input type="text" placeholder="votre nom" v-model="nom">
        </div>
        <div class="groupe">
          <label>Prenom</label>
          <input type="text" placeholder="votre prenom"  v-model="prenom">
        </div>
        <div class="groupe">
          <label>Date de Naissance</label>
          <input type="date" v-model="dateNaiss">
        </div>
        <div class="groupe">
          <label>Email</label>
          <input type="email" placeholder="votre adresse email"  v-model="email">
        </div>
        <div class="groupe">
          <label>Password</label>
          <input type="password" placeholder="********" v-model="password">
        </div>
        <button type="submit">Register</button>
    </form>
  </div>
</template>

<script>
export default{
    name:"Register",
    data(){
        return{
            nom: '',
            prenom:'',
            dateNaiss:'',
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
      async Register(e){
        e.preventDefault();
        const res = await fetch('http://localhost/Gestion_RDV_Vue3_API/app/Patient/register',{
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                email: this.email,
                nom: this.nom,
                prenom: this.prenom,
                dateNaiss: this.dateNaiss,
                password: this.password,
                })
            })
            const result = await res.json()
            const token = result.Token;
            let user = result.User;
            localStorage.setItem('token', token);
            localStorage.setItem('user', user);

            if(res.status == 200){
           
               window.location.replace("/")
            }
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
