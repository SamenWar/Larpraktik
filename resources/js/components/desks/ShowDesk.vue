        <template><div>
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
                    <div class="card-body">
                        <form v-if="desk_list_input_id==desk_list.id" @submit.prevent="updateDeskList(desk_list.id, desk_list.name)">
                            <input type="text" v-model="desk_list.name" class="form-control" placeholder="input name of List">
                                <button type="button" @click="desk_list_input_id=null" class="close mt-3">
                                    <span aria-hidden="true"></span>
                                </button>
                        </form>
                        <h4 @click="desk_list_input_id = desk_list.id" v-else class="card-title d-flex justify-content-between align-items-center" style="font-size: 15px; cursor: pointer">{{desk_list.name}}<i class="fa-solid fa-pencil" ></i></h4>

                        <div class="card mt-3 bg-light" style="">
                            <div v-for="card in desk_list.Cards" class="card-body">
                                <router-link class="card-body" :to="{name:'showCard', params:{cardId:card.id}}">
                                    <h4 class="card-title d-flex justify-content-between align-items-center">{{card.name}}</h4>
                                </router-link>

                                <button type="button" @click="deleteCard(card.id)" class="btn btn-danger mt-3">
                                    delete card
                                </button>
                            </div>
                        <button class="btn btn-danger mt-3" @click="deleteDeskList(desk_list.id)">Delete list</button>
                        </div>
                    </div>
                </div>
                <form>
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
                //------------------
                //card
                //___________________
            deleteCard(id){
                if (confirm('Are you sure?')) {
                    axios.post('/api/cards/'+ id, {
                        _method: 'DELETE'
                    }).then(response => {

                    })
                        .catch(error => {
                            console.log(error)
                            this.errored = true
                        }).finally(()=> {
                        this.loading = false})

                }
            },

                //-----------------------------
                //desk-list
                //-----------------------------
                deleteDeskList(id){
                    if (confirm('Are you sure?')) {
                        axios.post('/api/lists/'+ id, {
                            _method: 'DELETE'
                        }).then(response => {

                        })
                            .catch(error => {
                                console.log(error)
                                this.errored = true
                            }).finally(()=> {
                            this.loading = false})

                    }

                    },
                updateDeskList(id, name){
                    axios.post('/api/lists/'+id, {
                        _method:'PUT',
                        name

                    }).then(response => {
                        this.desk_list_input_id=null
                   })
                        .catch(error => {
                            console.log(error)
                            this.errored = true
                        }).finally(()=> {
                        this.loading = false})



                },




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


                axios.post('/api/lists', {
                    name: this.name
                }).then(response => {
                    this.name = ''
                    this.desk_lists=[]
                    this.getDeskLists()


                })
                    .catch(error => {
                        console.log(error)
                        if(error.response.data.errors.name){
                            this.errors=[]
                            this.errors.push(error.response.data.errors.name[0])
                        }
                        this.err
                    }).finally(()=> {
                    this.loading = false})



            },
            //-----------------------------------------------
                SaveName() {
                    axios.post('/api/desks/' + this.deskId, {
                        _method:'PUT',
                        name:this.name,
                    })
                        .then(response => {
                            this.name = response.data.data.name

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
