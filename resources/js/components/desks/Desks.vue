<template>
    <div class="container">
        <h1>Desks</h1>
        <form @submit.prevent="addDesks">
            <div class="form-group">
                <input type="text" v-model="name" class="form-control" placeholder="Enter name of new desk" :class="{'is-invalid': $v.name.$error}">
            </div>
            <button type="button" class="btn btn-primary mt-1">Add</button>
        </form>

        <!-- errors block -->
        <div v-if="!$v.name.required">
            Ошибка! Обязательное поле!
        </div>
            <div class="row">
            <div class="col-lg-4" v-for="desk in desks">
            <div class="card mt-4" style="width: 18rem;" >
                <div class="card-body">
                    <router-link class="card-body" :to="{name:'ShowDesk', params:{deskId:desk.id}}">
                        <h4>{{desk.id}} {{desk.name}}</h4>
                    </router-link>

                    <button type="button" @click="deleteDesk(desk.id)" class="btn btn-danger mt-3">Delete</button>
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
import {required, maxLength} from 'vuelidate/lib/validators'
export default {
    data(){
        return{
            desks:[],
            errored: false,
            loading: true,
            name:null
        }
    },
    mounted() {
        this.GetAllDesks()
    },
    methods:{
        addDesks(){
            this.$v.$touch()
            if(this.$v.$anyError) {
                return;
            }

            axios.get('api/desks').then(response => {
                this.desks = response.data.data
            })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                }).finally(()=>this.loading = false)

        },

        GetAllDesks(){
            axios.get('api/desks').then(response => {
                this.desks = response.data.data
            })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                }).finally(()=>this.loading = false)

        },

        deleteDesk(id) {
            if (confirm('Are you sure?')) {
                axios.post('/api/desks/'+ id, {
                     _method: 'DELETE'
                }).then(response => {
                    this.desks = []
                    this.GetAllDesks()
                })
                    .catch(error => {
                        console.log(error)
                        this.errored = true
                    }).finally(()=> {
                        this.loading = false})

            }


        },
        validations () {
            return {
                name:
                    {
                        maxLength: maxLength(255),
                        required
                    },
            }
        }

    }

}
</script>

