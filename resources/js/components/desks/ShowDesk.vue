        <template>
            <div>
            <!-- change name of desk -->
                <input type="text" @blur="SaveName" v-on:keyup.enter="SaveName" v-model="name" class="form-control" :class="{'is-invalid': $v.name.$error}">
        <div class="alert alert-danger" v-if="errored" role="alert">
            Ошибка! Ошибка!
        </div>
            <!-- errors block -->
        <div class="invalid-feedback" v-if="!$v.name.required">
            Ошибка! Обязательное поле!
        </div>

        <div class="invalid-feedback" v-if="!$v.name.maxLength">
            Ошибка! Максимальное количество символов:{{$v.name.$params.maxLength.max}}.
        </div>
        <div class="spinner-border text-success" v-if="loading" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>

        <!--add new list-->
        <div>
            <input type="text" @blur="SaveName" v-on:keyup.enter="SaveName" v-model="desk_list_name" class="form-control" :class="{'is-invalid': $v.desk_list_name.$error}">
        </div>

        <div class="invalid-feedback" v-if="!$v.desk_list_name.maxLength">
            Ошибка! Максимальное количество символов:{{$v.desk_list_name.$params.maxLength.max}}.
        </div>

        <div class="spinner-border text-success" v-if="loading" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>

        <!-- cards list -->
        <div class="row">
            <div class="col-lg-4" v-for="desk_list in desk_lists">
                <div class="card mt-4 " style="width: 18rem;" >
                    <h4 style="cursor: pointer " class="card-title">{{desk_list.name}}</h4>
                </div>
                <form>
                    <input type="text" v-model="desk_list.name" class="form-control" placeholder="input name of cord">
                </form>
            </div>

          </div>
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
                loading: true,
                desk_lists: true,
                desk_list_name:null,
                desk_list_input_id:null
            }
        },
        methods:{
                //-----------------------------
                //desk-list
                //-----------------------------

                getDeskLists(){
                axios.get('/api/lists', {
                     params:{
                      desk_id:this.deskId
                     }
                }).then(response => {

                    this.desk_lists = response.data.data
                    console.log(this.desk_lists)



                })
                    .catch(error => {
                        console.log(error)
                        this.errored = true
                    }).finally(()=> {
                        this.loading = false})



                },


            //___________________________________________________________


            addDeskLists(){
                    this.$v.$touch()
                    if(this.$v.anyError){
                        return;
                    }
                axios.post('/api/lists', {
                    name: this.desk_list_name
                }).then(response => {
                    this.desk_list_namee = ''


                })
                    .catch(error => {
                        console.log(error)
                        this.errored = true
                    }).finally(()=> {
                    this.loading = false})



            },
            //-----------------------------------------------
                SaveName() {
                   this.$v.$touch()
                   if(this.$v.$anyError){
                       return;
                   }

                    axios.post('/api/desks/' + this.deskId, {
                        name:this.desk_list_name,
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
                    },
                desk_list_name:

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

         this.getDeskLists()
         }


    }
    </script>
