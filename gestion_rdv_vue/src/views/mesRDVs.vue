<template>
  <div class="container">
    <table>
      <thead>
        <th>Date</th>
        <th>Periode</th>
        <th>Action</th>
      </thead>
      <tbody v-for="i in info" :key="i.id_r">
        <tr>
          <td>{{ i.date }}</td>
          <td>{{ i.periode }}</td>
          <td>
            <button class="edit" @click="getId(i.id_r)">Edit</button>
            <button class="delete" @click="Delete(i.id_r)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
    <div v-if="dispo.length" class="editt">
            <input type="date" v-model="date" @change="SearchByDate">
            <select v-model="periode" >
                <option :value="d" v-for ="(d,idx) in dispo" :key="idx">{{d}}</option>
            </select>
            <button @click="Edit()">OK</button>
        </div>
  </div>

</template>

<script>
export default {
  name: "mesRDVs",
  data() {
    return {
      info: [],
      id_r: "",
      date: "",
      periode: "",
      partReserved: [],
      dispo: [],
      part: ["9-10", "10-11", "11-12", "14-15", "15-16", "16-17"],
    };
  },
  methods: {
      async SearchByDate(){
          
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
                if(result.lenght != 0){
                    this.dispo=["9-10", "10-11", "11-12", "14-15", "15-16", "16-17"]
                }else{
                result.map(res=>{
                  this.partReserved.push(res.periode)                
                })
                this.dispo=[]
                let x = Object.values(this.partReserved);
                let y = Object.values(this.part);
                this.dispo = y.filter(e=>!x.includes(e));
                }
      },

    async getId(id_r) {
      let token = localStorage.getItem("Token");
      const res = await fetch(
        "http://localhost/Gestion_RDV_Vue3_API/app/Reservation/getReservationById",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Authorization: "Bearer " + token,
          },
          body: JSON.stringify({
            id_r: id_r,
          }),
        }
      );
      let result = await res.json();
      this.date = result.date;
      this.periode = result.periode;
      this.id_r = result.id_r;
      const partsR = await fetch(
        "http://localhost/Gestion_RDV_Vue3_API/app/Reservation/getReservationByDate",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Authorization: "Bearer " + token,
          },
          body: JSON.stringify({
            date: this.date,
          }),
        }
      );
      const resultt = await partsR.json();
      this.partReserved = [];
      resultt.map((res) => {
        this.partReserved.push(res.periode);
      });
      let x = Object.values(this.partReserved);
      let y = Object.values(this.part);
      this.dispo = y.filter(e=>!x.includes(e));
    },
    async getAll() {
      let token = localStorage.getItem("Token");
      var base64Url = token.split(".")[1];
      var base64 = base64Url.replace(/-/g, "+").replace(/_/g, "/");
      var jsonPayload = decodeURIComponent(
        atob(base64)
          .split("")
          .map(function(c) {
            return "%" + ("00" + c.charCodeAt(0).toString(16)).slice(-2);
          })
          .join("")
      );
      let Ref = JSON.parse(jsonPayload).ref;
      const res = await fetch("http://localhost/Gestion_RDV_Vue3_API/app/Reservation/getReservationByRef",{
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Authorization: "Bearer " + token,
          },
          body: JSON.stringify({
            ref: Ref,
          }),
        }
      );
      let result = await res.json();
      this.info = result.map((elm) => ({date: elm.date,periode: elm.periode,id_r: elm.id_r,
      }));
    },

    async Edit() {
      let token = localStorage.getItem("Token");
      await fetch("http://localhost/Gestion_RDV_Vue3_API/app/Reservation/editReservation",{
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Authorization: "Bearer " + token,
          },
          body: JSON.stringify({
            id_r: this.id_r,
            date: this.date,
            periode: this.periode,
          }),
        }
      );
      this.dispo=[]
      this.getAll();
    },

    async Delete(id_r) {
      let token = localStorage.getItem("Token");
      await fetch("http://localhost/Gestion_RDV_Vue3_API/app/Reservation/deleteReservation",{
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Authorization: "Bearer " + token,
          },
          body: JSON.stringify({
            id_r: id_r,
          }),
        }
      );
      this.getAll()
    },
  },
  created() {
    this.getAll()
  }
}
</script>

<style scoped lang="scss">
.container {
  width: 40%;
  margin-left: 30%;
  table {
    border-collapse: collapse;
    width: 100%;
    background-color: #e8f0fe;
    border: 1px solid rgb(9, 9, 83);
    font-weight: 600;

    thead {
      th {
        border: 1px solid rgb(9, 9, 83);
        text-align: left;
        padding: 8px;
        color: white;
        background-color: rgb(9, 9, 83);
        font-weight: 700;
      }
    }
    tbody {
      td {
        border: 1px solid rgb(9, 9, 83);
        color: rgb(9, 9, 83);
        text-align: left;
        padding: 8px;
        button {
          color: white;
          outline: none;
          border: none;
          border-radius: 5px;
          margin: 0 10px;
          font-weight: 700;
          padding: 10px 15px;
        }
        .edit {
          padding: 10px 25px;
          background-color: rgb(9, 9, 83);
        }
        .delete {
          background-color: rgb(194, 10, 10);
        }
      }
    }
  }
  .editt{
      display: flex;
      flex-direction: column;
      margin: 20px 0;
      background-color:#e8f0fe ;
      input{
            outline: none;
            width: 90%;
            padding: 12px 20px;
            margin: 8px 0  8px 5%;
            font-weight: 600;
            font-size: 17px;
            color: rgb(9, 9, 83);
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        select{
        font-weight: 600;
        width: 90%;
        font-size: 17px;
        background-color:white;
        color: rgb(9, 9, 83);
        padding: 14px 20px;
        margin:8px 0 8px 5%;
        border: none;
        border-radius: 4px;
        cursor: pointer;
      }
      button{
        width: 90%;
        font-weight: 600;
        font-size: 17px;
        background-color:rgb(9, 9, 83);
        color: white;
        padding: 14px 20px;
        margin:50px 0 8px 5%;
        border: none;
        border-radius: 5px;
        cursor: pointer;
      }
  }
}
</style>
