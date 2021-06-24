<template>
<div  class="container">
    <div class="search">
      <p>Select a Date</p>
      <input type="date" v-model="date" @change="SearchByDate" >
    </div>
    <div v-if="notEmpty">
      <div v-for="p in part" :key="p" class="component" >
        <periode  @newReservation="addRes" :partofday='p' :reserved= "verification(p)" :color = "verification(p)? 'rgb(9, 9, 83)' :'#E8F0FE'" />
      </div>
    </div>
</div>
    
  
</template>
<script>
import periode from '../components/periode'
export default {
  name:"Home",
   data(){
       return{
         date:'',
         notEmpty:false,
         partReserved:[],
         part:["9-10","10-11","11-12","14-15","15-16","16-17"]
       }
    },
    components:{
      periode
    },
    beforeMount(){
      this.logged()
    },
   methods:{
     async addRes(partofday){
            let token=localStorage.getItem('Token')
            var base64Url = token.split('.')[1];
            var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
            var jsonPayload = decodeURIComponent(atob(base64).split('').map(function (c) {
                return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
            }).join(''));
            let Ref= JSON.parse(jsonPayload).ref;
                const res = await fetch("http://localhost/Gestion_RDV_Vue3_API/app/Reservation/newReservation",{
                    method: 'POST',
                    headers: {
                      "Content-Type":"application/json",
                      "Authorization":"Bearer "+token
                    },
                    body:JSON.stringify({
                      "periode": partofday,
                      "ref" : Ref ,
                      "date" : this.date
                    })
                })
                const result = await res.json()
                console.log(result);
                //  this.notEmpty=false
               this.SearchByDate()

     },
     async SearchByDate(){
       this.notEmpty=true
      console.log(this.notEmpty);
       let token=localStorage.getItem('Token')
                const res = await fetch("http://localhost/Gestion_RDV_Vue3_API/app/Reservation/getReservationByDate",{
                    method: 'POST',
                    headers: {
                      "Content-Type":"application/json",
                      "Authorization":"Bearer "+token
                    },
                    body:JSON.stringify({
                      "date": this.date
                    })
                })
                const result = await res.json()
              
                result.map(res=>{
                  this.partReserved.push(res.periode)                
                })
      },
      verification(p){
        if(this.partReserved.includes(p)){
          return false
        }else{
          return true;
        }
      },
      logged(){
        let user = localStorage.getItem('user')
        if(user == null){
            $route.push('/Login')
        }else{
        return true
        }
      }
    }
}
</script>
<style scoped lang="scss">
.container{
    width: 30%;
    height: 100vh;
    margin-left: 35%;
    .search{
      display: flex;
      flex-direction: column;
      border-radius: 5px;
      background-color: #E8F0FE;
      padding: 20px;
      p{
        margin:30px 0 10px 0;
        font-weight: 600;
        font-size: 20px;
        color:rgb(9, 9, 83);
      }
      input{
            outline: none;
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            font-weight: 600;
            font-size: 17px;
            color: rgb(9, 9, 83);
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
      }
    }
   .component{
    display: flex;
    justify-content: center;
    align-content: center;
    width: 100%;
   }

}

</style>