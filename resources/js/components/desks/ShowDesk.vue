<template>
<div>
<!--    :class="{'is-invalid': $v.name.$error}"-->
    <h2>show</h2>
    <input type="text" @blur="SaveName" v-on:keyup.enter="SaveName" v-model="name" class="form-control" :class="{'is-invalid': $v.name.$error}">
    <div class="alert alert-danger" v-if="errored" role="alert">
        Ошибка! Ошибка!
    </div>

    <div class="invalid-feedback" v-if="!$v.name.required">
        Ошибка! Обязательное поле!
    </div>

    <div class="invalid-feedback" v-if="!$v.name.maxLength">
        Ошибка! Максимальное количество символов:{{$v.name.$params.maxLength.max}}.

    </div>
    <div class="spinner-border text-success" v-if="loading" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
    <button type="button" class="btn btn-danger">Delete</button>
</div>
</template>

<script>
import { validationMixin } from 'vuelidate'
import Vuelidate from 'vuelidate'
import { required, maxLength } from 'vuelidate/lib/validators'
// Vue.use(Vuelidate)
export default {
            props: [
                'deskId'
            ],
        data(){
            return{

                name:null,
                errored: false,
                loading: true
            }
        },
        methods:{
                SaveName() {
                   this.$v.$touch()
                   if(this.$v.$anyError){
                       return;
                   }

                    axios.post('/api/desks/' + this.deskId, {
                        _method: 'PUT',
                        name: this.name
                    })
                        .then(response => {
                    })
                        .catch(error => {
                            console.log(error)
                            this.errored = true
                        }).finally(() => this.loading = false)
                }

        },
        validations () {
            return {
                name:
                    {
                        maxLength: maxLength(255),
                        required
                    }

            }
        },
         mounted(){
             axios.get('/api/desks/'+this.deskId).then(response => {
                 this.name = response.data.data.name          })
                 .catch(error => {
                     console.log(error)
                     this.errored = true
                 }).finally(()=>this.loading = false)
         }

    }
</script>

