<template>
    <div class="container">
        <div class="row justify-content-center">
      <div class="col-md-9 mt-4">
   <div class="card card-default">
          <div class="card-header" >
            <h3 class="card-title">Detaille De projets:</h3>
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Project Files:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
               <form @submit="formSubmit" enctype="multipart/form-data">
                 <label for="name">Name</label></input>  <input id="name" class="form-control" type="text" name="name"></input>
                 <div class="input-group mt-2"><div class="custom-file"><input type="file" name="file" v-on:change="onFileChange" class="custom-file-input"> <label for="exampleInputFile" class="custom-file-label">
                     Choose file:</label></div></div>

                      <button  class="btn btn-success mt-2">Submit</button>

               </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>


      </div>
    </div>
  </div>
</div>

            <div class="card-tools">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                   <i class="fas fa-plus"></i>            Project File
                    </button>

              <button type="button" class="btn btn-tool" id="reduit" data-card-widget="collapse"><i class="fas fa-minus"></i></button>

            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body" style="display: block;">
            <div class="row">
               <div v-for="projet in projets"  v-if=" projet.id == key"  :key="projet.id" >
                   <label>Nom de Projet:</label>
                        <p>{{ projet.name }}</p>
                 <label>Budget de projet:</label>
                 <p>{{ projet.budget }}</p>
                 <label>Durée de Projet :</label>
                 <p>{{ projet.durre }}</p>
                  <label>Client:</label>
                 <p>{{ projet.owner }}</p>
                  <label>Descriptoin de projet:</label>
                 <p>{{ projet.description }}</p>
              <label>File of  Project:</label>
                <div v-for="file in files" :key="file.id" >
                    <ul >
                 <li>  <p><a style="text-decoration:none; color:black;"  :href="`//127.0.0.1:8000/upload/${file.file}`" target="_blank"> <i class="fas fa-file-alt"></i>{{ file.file }}</a></p></li>
                </ul>
                </div>



    </div>

            </div>
            <!-- /.row -->


            <!-- /.row -->
          </div>
          <!-- /.card-body -->

            </div>
               </div>
               <div class="col-md-9 mt-4">
                      <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">les Membres de Projets</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" id="reduit" data-card-widget="collapse"><i class="fas fa-minus"></i></button>

            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body" style="display: block;">
            <div class="row">
               <div >
                <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Nom</th>
                      <th>Role/Poste</th>
                    </tr>
                  </thead>
                   <tbody>
                   <tr  v-for="membre in membres"  v-if=" key == membre.projet_id "  :key="membre.id"  >
                     <td> {{ membre.membre }}  </td>
                                    <td>{{ membre.role }}</td>
                   </tr>
                 </tbody>
                </table>   <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            </div>
          </div>
            <!-- /.row -->


            <!-- /.row -->
          </div>
          <!-- /.card-body -->

            </div>
                  <div class="col-md-9 mt-4">
                      <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Commentaires</h3>


                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" id="reduit" data-card-widget="collapse"><i class="fas fa-minus"></i></button>

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="display: block;">
                        <div class="row">
                        <div >
                            <div class="card-body table-responsive p-0">
                                <div class="col-md-12 ">
                        <div class="form-group" style="display: inline;" >
                            <form @submit.prevent="ajouterCommentaire()">
                            <label>Votre Commentaire:</label>


                            <div class="input-group input-group-sm mb-0">
                            <input class="form-control form-control-sm" v-model="form.body" type="text" name="body"
                            :class="{ 'is-invalid': form.errors.has('body') }"  placeholder="commenter.." style="width:450px;">
                            <has-error :form="form" field="body"></has-error>
                                    <div class="input-group-append">
                                            <button type="submit" class="btn btn-success "  >Commenter</button>
                                    </div>
                                    </div>
                            </form>
                            </div>
                            <div v-for="comment in comments"  :key="comment.id"   v-if=" key == comment.commentable_id  "  class=" align-items mt-3">

                            <hr>
                            <span class="badge badge-primary"> {{ comment.comment_user_name }}</span >&nbsp;&nbsp; {{ comment.body }}
                            &nbsp;&nbsp;&nbsp; <b> <small class="badge badge-success" style="float:right; color:#2d132c " >Posté le {{ comment.created_at || date }} </small></b>
                                   <br>
                                   <div v-for="commentreply in commentsreply"  :key="commentreply.id"   v-if=" comment.id == commentreply.commentable_id "  class=" align-items mt-3">


                                  <span style="color :red;">Réponse:</span> <span class="badge badge-primary ml-4"> {{ commentreply.comment_user_name }}</span >&nbsp;&nbsp; {{ commentreply.body }}
                            &nbsp;&nbsp;&nbsp; <b> <small class="badge badge-success" style="float:right; color:#2d132c " >Posté le {{ commentreply.created_at || date }} </small></b>
                                   <br>
                            </div>
                        <button @click="showbtn(comment.id)"   class="btn btn-default"  >Répondre</button>
                            <form    type="post"  @submit.prevent="ajouterCommentaireReponse(comment.id)"  v-bind:id="comment.id "  class="d-none">


                         <div class="input-group input-group-sm mt-2 ml-2">
                            <input class="form-control form-control-sm" name="replycomment"  v-model="form1.body" type="text"
                                                   :class="{ 'is-invalid': form1.errors.has('body') }"  placeholder="commenter.." style="width:450px;">
                            <has-error :form="form1" field="replycomment"></has-error>
                                    <div class="input-group-append">
                                            <button type="submit" class="btn btn-success "  >Commenter</button>
                                    </div>
                          </div>
                            </form>

                            </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        </div>
                        </div>
                    </div>
                        <!-- /.row -->


                        <!-- /.row -->
                    </div>
                    <!-- /.card-body -->

                        </div>
                        </div>
              </div>


            </template>
   <script>
            export default {
            data(){  return{
                key: this.$route.params.id,
                projets:[],
                projet:{
                id:'',
                name:'',
                durre:'',
                description:'',
                budget:'',
                owner:'',},
                membres:[],  membre:{   id :'',membre:'',projet_id:'', },
                form : new Form({id:'',body:'',user:'',}),
                 form1 : new Form({id:'',body:'',user:'',}),
                comments:[],comment:{id:'',body:'',created_at:''},
                commentsreply:[],
                commentreply:{
                  id:'',
                  body:'',
                  created_at:''
                },
                   files:[],
               name: '',
              file:{
                name:'',
                id:''
              },
              success: ''
                 }},
                 methods:{
              onFileChange(e){
                console.log(e.target.files[0]);
                this.file = e.target.files[0];
            },
            formSubmit(e) {
                e.preventDefault();
                let currentObj = this;

                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }

                let formData = new FormData();
                formData.append('file', this.file);

                axios.post('/api/formSubmit/'+this.key, formData, config)
                .then(function (response) {
                    fire.$emit('ajoutdetail');
                    $("#exampleModal").modal('hide');
                    currentObj.success = response.data.success;
                })
                .catch(function (error) {
                    currentObj.output = error;
                });
            },
            afficherProjets(){
            axios.get('/api/getProjects')
                .then(({data}) => {this.projets=data.data});},
            afficherMembre(){
            axios.get('/api/membreid').then(({data})=> {this.membres = data.data});},
            ajouterCommentaire(){
                this.form.post('/api/comments/'+this.key).then(()=>{
                                    fire.$emit('ajoutcommentaire');
                this.form.reset()})},
            ajouterCommentaireReponse(commentId){
            this.form1.post('/api/commentsreponse/'+ commentId)
            .then(()=>{
                fire.$emit('ajoutcommentaire');
               this.form1.reset();
            })
            },

            afficherComments(){
            axios.get('/api/comments').then(({data})=> {this.comments =data.data});},
            // afficherComments(){
            //axios.get('/api/commentsreply').then(({data})=> {this.commentsreply =data.data});},
            showbtn(id){
                let element= document.getElementById(id);
                element.classList.toggle('d-none');},
            have(){
                let key = document.getElementById("pm").innerHTML;
                return key;},
            showreply(){
             axios.get('/api/commentreply').then(({data})=> {this.commentsreply =data.data});},
            },

                created(){
                    fire.$on('ajoutdetail',()=>{
                 axios.get('/api/file/'+this.key).then(({data}) => {this.files =data.data});
                    }),
                    axios.get('/api/file/'+this.key).then(({data}) => {this.files =data.data});
                    fire.$on('ajoutcommentaire',()=>{
  this.afficherComments();});
                      fire.$on('ajoutcommentaire',()=>{
  this.showreply();

                 });

                },
            mounted() {
            console.log('Component mounted.')
            this.afficherProjets();
            this.afficherMembre();
            this.afficherComments();
            this.showreply();

            }}
            </script>
<style lang="css" scoped>
.card-header{
    background-color:#007bff;
}
.card-title {
    color: aliceblue;
}

#reduit{
    color:blanchedalmond;
}
</style>



