<template>
<div>
    <h3>{{name}}</h3>
    <div class="accordion" id="accordionExample">
        <div v-for="task in tasks" class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    {{task.name}}
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="mb-3">
                        <label for="Task_name" class="form-label">Task name</label>
                        <input type="email" class="form-control" id="Task_name" placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="deadline" class="form-label">Deadline</label>
                        <input type="date" class="form-control" id="deadline" placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="executor" class="form-label">Executor</label>
                        <input type="text" class="form-control" id="executor" placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary mt-1">Change task</button>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-danger mt-1">Delete task</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: "showCard",
    props:[
      'cardId'
    ],
    data(){
        return{

            name:null,
            errored: false,
            loading: true,
            tasks: true,
            taskData:null

        }
    },
    methods:{
        getCard(id){

        },
      getTasks(){
          axios.get('/api/tasks', {
              params:{
                  card_id:this.cardId
              }
          }).then(response => {

              this.tasks = response.data.data
              console.log(this.tasks)



          })
              .catch(error => {
                  console.log(error)
                  this.errored = true
              }).finally(()=> {
              this.loading = false})



      },
      createTask(cardId){},

        updateTask(id){},
        deleteTask(id){},

        ShowCard(){}
    },

    mounted(){
        axios.get('/api/cards/'+this.cardId).then(response => {
            this.name = response.data.data.name
        })
            .catch(error => {
                console.log(error)
                this.errored = true
            }).finally(()=>this.loading = false)

        this.getTasks(this.cardId)
    }
}


</script>


