<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-4">
            <div class="card" v-if="$acces.Admin()">
              <div class="card-header">
                <h3 class="card-title">Les Projets:</h3>

                <div class="card-tools">
                      <button class="btn btn-success ml-6 mb-3"  @click="newer" ><i class="fas fa-project-diagram"></i> Ajouter</button>

                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Nom</th>
                      <th>Client</th>
                      <th>Description</th>
                      <th>Durée estimé</th>
                      <th>Budget estimé</th>
                      <th>Avancemant</th>
                      <th>Operation</th>
                    </tr>
                  </thead>
                  <tbody>
                   <tr v-for="projet in projets.data" :key="projet.id" >
               <router-link :to="`/detail/${projet.id}`" style="text-decoration:none; color:black;">        <td>{{ projet.name }}</td></router-link>

                      <td>{{ projet.owner }}</td>

                      <td><a  style=""  href="#" @click="chargerid(projet.description)" class="btn btn-secondary"><i data-toggle="modal" data-target="#description"  class="fas fa-sticky-note"></i></a></td>
                      <td>{{ projet.durre }}</td>
                      <td>{{projet.budget}}</td>
                      <td>-------</td>
                      <td><a href="#" class="btn" style="background-color: #00a8cc" @click="editProjet(projet)" ><i style="color:#fff" class="fas fa-user-edit"></i></a>
                       <a href="#" class="btn btn-danger" @click="deleteProjet(projet.id)" ><i class="fas fa-trash-alt"></i></a>

                  </td>





<!-- Modal -->
<div class="modal fade" id="description" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Description</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      {{ desc }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>

                    </tr>

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

            </div>
            <pagination :data="projets" @pagination-change-page="getResults"></pagination>
            </div>
        </div>
 <div v-if="!$acces.Admin()">
   <not-found></not-found>
 </div>
        <div class="modal fade" id="AjouterProjet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
         <div class="modal-header">
        <h5 class="modal-title" v-show="!x" id="exampleModalLabel">Ajouter Projet:</h5>
         <h5 class="modal-title" v-show="x" id="exampleModalLabel">Modifier Projet:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <form @submit.prevent=" x ? modifier():ajouterProjet()">
          <div class="modal-body">
     <div class="form-group">
      <label>Nom</label>
      <input v-model="form.name" type="text" name="name"
        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
      <has-error :form="form" field="name"></has-error>
    </div>
     <div class="form-group">
      <label>Client</label>

      <select v-model="form.client_id"   type="text" name="client_id"
        class="form-control" :class="{ 'is-invalid': form.errors.has('client_id') } "   >
        <option value="" selected>Selectez Le Client</option>
        <option v-for = "(client , index) in clients" :key="index" v-bind:value="client.id">{{ client.name }}</option>
      </select>
      <has-error :form="form" field="client_id"></has-error>
    </div>

        <div class="form-group" v-if="!$acces.Chef()">
      <label>Chef de Projet</label>
      <select v-model="form.chefprojet" type="text" name="chefprojet"
        class="form-control" :class="{ 'is-invalid': form.errors.has('chefprojet') }">
        <option selected value="">Selecter Un Chef de projet</option>
         <option v-for = "(chef , index) in chefs" :key="index" v-bind:value="chef.id">{{ chef.name }}</option>

      </select>
      <has-error :form="form" field="chefprojet"></has-error>

    </div>
    <div v-show="!x">
                <label>Membres</label>
                <select   v-model="form.membre_id" type="text" name="membre_id[]" class="form-control" :class="{ 'is-invalid': form.errors.has('membre_id') } " multiple="multiple">
                  <option value>Selectez Les membres</option>
                  <option v-for="(membre , index) in membres" :key="index" v-bind:value="membre.id">
                        {{ membre.name }}
                  </option>
                </select>
                <has-error :form="form" field="membre_id"></has-error>
     </div>

     <div class="form-group" >
      <label>Duree</label>
      <input v-model="form.durre" type="text" name="durre"
        class="form-control" :class="{ 'is-invalid': form.errors.has('durre') } ">
      <has-error :form="form" field="durre"></has-error>
    </div>

     <div class="form-group">
      <label>Description</label>
      <textarea v-model="form.description" type="text" name="description"
        class="form-control" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
      <has-error :form="form" field="description"></has-error>
    </div>
     <div class="form-group">
      <label>Budget</label>
      <input v-model="form.budget" type="text" name="budget"
        class="form-control" :class="{ 'is-invalid': form.errors.has('budget') }">
        <has-error :form="form" field="budget"></has-error>
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" v-show="!x" class="btn btn-primary" >Ajouter</button>
        <button type="submit" v-show="x" class="btn btn-primary" >Modifier</button>
      </div>
      </form>
    </div>

  </div>

</div>
<!-- chef de projet-->

    </div>
</template>

<script>
    export default {
             data(){
                 return{
                     x:false,
              projets:{},
              projet:{
                  id:''
              },

            desc:'',
       form : new Form({
           id:'',
           name:'',
           durre:'',
           description:'',
           budget:'',
           owner:'',
           membres: "",
        client_id:"",
        membre_id: [],
        chefprojet:''


       }),

           clients:[],

           client:{
              id:'',
              name:'',
          },
            membres: [],
           membre: {
            id: "",
           name: ""
            },
      projetusers:[],
      projetuser:{
          id: "",
           name: ""

      },
      chefs:[],
      chef:{
          id:'',
          name:''
      }


                 }


             },


         created(){
          //   axios.get('api/getc');

      this.afficherClient();
      this.afficherMembres();
      this.afficherProjet();
      this.afficherChef();

   fire.$on('ajoutprojet',()=>{
  this.afficherProjet();
                 });

                       },
           methods:{getResults(page = 1) {
			axios.get('api/projet?page=' + page)
				.then(response => {
					this.projets = response.data;
				});
		},
               ajouterProjet(){
                this.form.post("api/projet").then(()=>this.form.post('api/chefdeprojet').then(()=>this.form.post('api/userprojet').then(()=>{
                fire.$emit('ajoutprojet');
                this.form.reset();
                $("#AjouterProjet").modal('hide');
                Toast.fire({
                        icon: 'success',
                        title: 'Projet Ajouter'

                })

                }).catch((response)=>{ console.log(response);


                 })).then(()=>{axios.post('/api/clientpname')
                      }));
                    },

             deleteProjet(id){
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
                    this.form.delete('api/projet/' + id).then(function(){

                    seww.fire(
                    'Supprimer!',
                    'Le projet est supprimer.',
                    'success'
                    )

             fire.$emit('ajoutprojet');

                }).catch(()=>{
                    seww.fire(
                    'Échec !!!!'


                    );
                });
           }
                })
            },
            modifier(){

               this.form.put('api/projet/'+ this.form.id).then(function(){

             $('#AjouterProjet').modal('hide')

                    seww.fire(
                    'Modifier!',
                    'Your User has been Updated.',
                    'success'
                    )
                    fire.$emit('ajoutprojet');

             }).catch(function(){

             })
            },
              editProjet(projet){
                  this.x=true;
               $("#AjouterProjet").modal('show');
               this.form.fill(projet)
              },
              newer(){
                  this.x=false
                  this.form.reset();

           $("#AjouterProjet").modal('show')
              },
               afficherClient(){
                   axios.get('api/clientp').then(({data})=>(this.clients =data.data));

               },
               chargerid($description){
                     this.desc=$description;
                   },
               afficherProjet(){
                   axios.get('api/projet').then(({ data }) =>(this.projets = data));
                   },
                    afficherMembres() {
                axios.get("api/membrep").then(({ data }) => (this.membres = data.data));
                       },
                   afficherChef(){
                axios.get("api/chef").then(({ data }) => (this.chefs = data.data));

                   }

                       }, name:'project'
           }


</script>
