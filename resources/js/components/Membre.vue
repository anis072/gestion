<template>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-4">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Les Membres:</h3>

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

                      <th>Role</th>
                      <th>Telephone</th>
                      <th>Created_at</th>
                      <th>Operation</th>
                    </tr>
                  </thead>
                  <tbody>

                    <tr v-for="user in users.data" :key="user.id">

                      <td>{{ user.name }}</td>
                      <td>{{ user.email }}</td>
                      <td>{{ user.role }}</td>
                      <td>{{ user.tel }}</td>
                      <td>{{ user.created_at | date }}</td>
                      <td>
                            <a  class="btn"  style="background-color: #00a8cc"><i style="color:#fff;"  @click="editMembre(user)" class="fas fa-user-edit" ></i></a>
                           <a href="#" class="btn btn-danger"><i class="fas fa-trash-alt"  @click="supprimerMembre(user.id)"></i></a>
                  </td>
                    </tr>

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <pagination :data="users" @pagination-change-page="getResults"></pagination>
            </div>
        </div>
        <!-- Modal -->
    <form @submit.prevent="x ? misajour(): ajouterMembre()">
<div class="modal fade" id="AjouterMembre" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">

         <h5 class="modal-title" v-show="!x" id="exampleModalLabel">Ajouter Membre:</h5>
         <h5 class="modal-title" v-show="x" id="exampleModalLabel">Modifier Membre:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
      <label>Nom</label>
      <input v-model="form.name" type="text" name="name"
        class="form-control" :class="{ 'is-invalid': form.errors.has('nom') }">
      <has-error :form="form" field="nom"></has-error>
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
      <label>Role</label>
      <select v-model="form.role" type="text" name="role"
        class="form-control" :class="{ 'is-invalid': form.errors.has('role') }">
        <option selected>Selecter Un role</option>
         <option v-for = "(role , index) in roles" :key="index" v-bind:value="role.role">{{ role.role }}</option>

      </select>
      <has-error :form="form" field="role"></has-error>

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
         <button type="submit" v-show="!x" class="btn btn-primary" >Ajouter</button>
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
                users:{},
                roles:{},
                role:{
                    id:'',
                  role:''
                },

                form : new Form({
                id:'',
                name:'',
                email:'',
                password:'',
                role:'',
                tel:''
                })
            }
        },

               methods:{
              getResults(page = 1) {
			axios.get('api/membre?page=' + page)
				.then(response => {
					this.users = response.data;
                });
               },
                   afficherMembre(){
                   axios.get('api/membre').then(({ data }) =>(this.users = data));
                   },
               ajouterMembre(){
                this.form.post('api/membre').then(()=>{
                fire.$emit('ajoutmembre');
                $("#AjouterMembre").modal('hide');

                Toast.fire({
                        icon: 'success',
                        title: 'Membre Ajouté'
                        })

                }).catch(()=>{

                });
                },
                misajour(){

               this.form.put('api/membre/'+ this.form.id).then(function(){

             $('#AjouterMembre').modal('hide')

                    seww.fire(
                    'Modifier!',
                    'Your User has been Updated.',
                    'success'
                    )
                    fire.$emit('ajoutmembre');

             }).catch(function(){

             })
            },
              editMembre(user){
                  this.x=true;
               $("#AjouterMembre").modal('show');
               this.form.fill(user)
              },
              newer(){
                  this.x=false
                  this.form.reset();

           $("#AjouterMembre").modal('show')
              },
                supprimerMembre(id){
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
                    this.form.delete('api/membre/' + id).then(function(){

                    seww.fire(
                    'Supprimer!',
                    'Le membre est supprimer.',
                    'success'
                    )
             fire.$emit('ajoutmembre');
                }).catch(()=>{
                    seww.fire(
                    'Échec !!!!'


                    );
                });
           }
                })
            },
                  getRole(){
                      axios.get('/api/role').then(({data})=>{
                this.roles = data.data;
                      });
                  }
             },
             created(){
                 this.afficherMembre();
                   fire.$on('ajoutmembre',()=>{
                     this.afficherMembre();
                 });
                 this.getRole();
             }

    }
</script>
