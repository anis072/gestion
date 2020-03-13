<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
              <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Configuration:</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form   @submit.prevent="modifierdonnées()">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Adresse Email:</label>
                    <input type="email" class="form-control"  placeholder="Votre Email" name="email" v-model="form.email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Mot de passe</label>
                    <input type="password" class="form-control"   placeholder="Mot De passe" name="password" v-model="form.password">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choisir un fichier:</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Télécharger</span>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
              </form>
              <form @submit.prevent="ajoutrole()" v-if="$acces.Admin() " >
                <div class="card-body">
                   <div class="form-group">
                    <label >Poste Ou Role:</label>
                    <input  v-model="form.role" type="text" :class="{ 'is-invalid': form.errors.has('budget') }" class="form-control"  name="role" placeholder="Poste ou Role">
                 <has-error :form="form" field="role"></has-error>
                  </div>

                 </div>
                 <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
              </form>
            </div>
            </div>

        </div>
    </div>
</template>

<script>
  export default {
   data(){
        return{
   form : new Form({
           id:'',
           role:'',
           password:'',
           email:''
       }),
           }
   },
        name:'setting',
        methods: {
            ajoutrole(){
                this.form.post('api/role').then(()=>{
                this.form.reset();
                Toast.fire({
                        icon: 'success',
                        title: 'Role Ajouter'
                        })
                }).catch(()=>{
                });;
            },
            modifierdonnées(){
this.form.post('api/updateuserconnecte/').then(()=>{
                this.form.reset();
                Toast.fire({
                        icon: 'success',
                        title: 'Données Modifié'
                        })
                }).catch(()=>{
                });;;
            }
        },
    }
</script>
