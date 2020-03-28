<template>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-4" v-if="$acces.Admin()" >
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Les Clients:</h3>

                <div class="card-tools">
                  <button class="btn btn-success ml-6 mb-3"  @click="newer()"><i class="fas fa-user"></i> Ajouter </button>

                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Nom</th>
                      <th>Email</th>
                      <th>Telephone</th>
                      <th>Created_at</th>
                      <th>Operation</th>
                    </tr>
                  </thead>
                  <tbody>

                    <tr v-for="client in clients.data" :key="client.id" >
                       <router-link :to="`/client/${client.id}`" style="text-decoration:none; color:black;"> <td>{{ client.name }}</td></router-link>
                      <td >{{ client.email }}</td>
                      <td>{{ client.tel }}</td>
                      <td>{{ client.created_at | date }}</td>
                      <td>
                  <a href="#" class="btn " style="background-color: #00a8cc" @click="editClient(client)" ><i style="color: #fff" class="fas fa-user-edit"></i></a>
                 <a href="#" class="btn btn-danger" @click="deleteClient(client.id)"   ><i      class="fas fa-trash-alt"></i></a>
                      </td>
                    </tr>

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <pagination :data="clients" @pagination-change-page="getResults"></pagination>
            </div>
        </div>
         <div v-if="!$acces.Admin()">
   <not-found></not-found>
 </div>
               <!-- Modal -->
    <form @submit.prevent=" x ? modifier() :ajouterClient()">
<div class="modal fade" id="AjouterClient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" v-show="!x">Ajouter Client:</h5>
        <h5 class="modal-title" id="exampleModalLabel" v-show="x">Modifier Client:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
      <label>Nom</label>
      <input v-model="form.name" type="text" name="name"
        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
      <has-error :form="form" field="name"></has-error>
    </div>
     <div class="form-group">
      <label>Email</label>
      <input v-model="form.email" type="text" name="email"
        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
      <has-error :form="form" field="email"></has-error>
    </div>
     <div class="form-group">
      <label>Password</label>
      <input v-model="form.password" type="password" name="password"
        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
      <has-error :form="form" field="password"></has-error>
    </div>
     <div class="form-group">
      <label>Telephone</label>
      <input v-model="form.tel" type="text" name="tel"
        class="form-control" :class="{ 'is-invalid': form.errors.has('tel') }">
      <has-error :form="form" field="tel"></has-error>

    </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" v-show="!x" class=" btn btn-primary">Ajouter</button>
         <button type="submit" v-show="x" class="btn btn-primary" >Modifier</button>
      </div>
    </div>
  </div>
</div>
    </form>
    </div>
</template>



<script>
    export default {
        data(){
            return{
                x:false,
                clients:{},
                client:{
                },

                form : new Form({
                id:'',
                name:'',
                email:'',
                password:'',
                tel:''
                }),
                projets:[],
                projet:{
                    id:'',
                    name:'',
                }

            }
        },

               methods:{  getResults(page = 1) {
			axios.get('api/client?page=' + page)
				.then(response => {
					this.clients = response.data;
                });
               },
                 deleteClient(id){
           seww.fire({
            title: 'Êtes-vous sûr?',
            text: "Vous ne pourrez pas revenir en arrière!",
            icon: 'warning',

            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Supprimer!'
            }).then((result) => {
           if(result.value){
                    this.form.delete('api/client/' + id).then(function(){

                    seww.fire(
                    'Supprimer!',
                    'Le client est supprimer.',
                    'success'
                    )

             fire.$emit('ajoutclient');

                }).catch(()=>{
                    seww.fire(
                    'Échec !!!!'


                    );
                });
           }
                })
            },

                   afficherClient(){
                   axios.get('api/client').then(({ data }) =>(this.clients = data));
                   },
               ajouterClient(){
                this.form.post('api/client').then(()=>{
                    this.form.reset();
                fire.$emit('ajoutclient');
                $("#AjouterClient").modal('hide');

                Toast.fire({
                        icon: 'success',
                        title: 'Client Ajouter'
                        })
                }).catch(()=>{

                });



               },
               modifier(){

               this.form.put('api/client/'+ this.form.id).then(function(){

             $('#AjouterClient').modal('hide')

                    seww.fire(
                    'Modifier!',
                    'Your User has been Updated.',
                    'success'
                    )
                    fire.$emit('ajoutprojet');

             }).catch(function(){

             })
            },
              editClient(client){
                  this.x=true;
               $("#AjouterClient").modal('show');
               this.form.fill(client)
              },
              newer(){
                   this.x=false
                  this.form.reset();

         $("#AjouterClient").modal('show')


              },

             },
             created(){
                 this.afficherClient();
                 fire.$on('ajoutclient',()=>{
                     this.afficherClient();
                 });


             }
    }
</script>
