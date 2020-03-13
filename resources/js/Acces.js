export default class  Acces {
     constructor(user){
       this.user=user;
     }
     Admin(){
         return this.user.role ==="admin";
     }
     user(){
         return this.user.role !== this.Admin();
     }
     Chef(){
         return this.user.role === "chef de projet";
     }
};
