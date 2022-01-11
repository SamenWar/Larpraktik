<template>
    <div class="container">
        <h1>desks</h1>
        <div class="row">
        <div class="col-lg-4">
            <div class="card mt-3" style="width: 18rem;" v-for="desk in desks">
                <img src='#' class="card-img-top" alt="...">
                <div class="card-body">
                    <router-link class="card-body" :to="{name:'ShowDesk', params:{deskId:desk.id}}">
                        <h4>{{desk.id}} {{desk.name}}</h4>
                    </router-link>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
        <div class="spinner-border text-success" v-if="loading" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="alert alert-danger" v-if="errored" role="alert">
            Ошибка! Ошибка!
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            desks:[],
            errored: false,
            loading: true
        }
    },
    mounted() {
        axios.get('api/desks').then(response => {
            this.desks = response.data.data
        })
            .catch(error => {
                console.log(error)
                this.errored = true
            }).finally(()=>this.loading = false)
    }
}
</script>

