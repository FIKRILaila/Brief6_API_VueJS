<template>
    <div id="part" :style = "{background: color}">
        <h3>{{partofday}}</h3>
        <p v-if="!reserved">Reserved</p>
        <button v-if="reserved" @click="onClick(partofday)">book now</button>
    </div>
</template>

<script>
export default {
    let:"part",
    name:"periode",
    props:{
        partofday :String,
        reserved : Boolean,
        color : String
        
    },
    methods:{
        onClick(partofday){
            this.$emit('newReservation',partofday)
        }
    }
}
</script>
<style scoped lang="scss">
#part{
    width: 100%;
    display: flex;
    justify-content: space-between;
    margin: 15px 0;
    padding: 10px;
    border-radius: 8px;
    h3{
        color: white;
        margin-left:10px ;
    }
    p{
        font-weight: 600;
        color:red;
    }
    button{
        border-radius: 5px;
        border: none;
        outline: none;
        font-size: 17px;
        font-weight: 600;
        padding: 0 10px;
        color:rgb(9, 9, 83) ;
        background-color: white;
    }
}
</style>