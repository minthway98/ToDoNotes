<template>

    <div class="container" >
        <div class="  p-3 mb-5  bg-warning	box" >
                <div class=" text-warning" v-show="noteform">
                
                    <input type="text" ref="NoteTitle" class="input form-control bg-warning " placeholder="Title"> <br>

                </div>  
            <br>
                <div class=" text-warning">
                    
                    <textarea ref="NoteBody" class="textarea  form-control bg-warning"  rows="1" @click="createnote"  @keydown="ExpandTextArea()" placeholder="Take a note"></textarea>
                    <!-- <input type="text" class="form-control" placeholder="title" > -->
                </div>
                <div class="image-upload" v-show="noteform">
                    <label for="file-input">
                        <i class="fas fa-camera fa-2x"></i>
                    </label>

                    <input id="file-input" type="file"/>
                </div>
            <br>
            <button class="btn btn-warning" v-show="noteform" @click="storenote()">Close</button>           
        </div> <br>
        <div class="container " >
           <div class=" card-columns">
               
                <div class="card p-3 bg-warning box box-shadow" 
                    v-for="note in notes" :key='note.id'  >
                <blockquote class="blockquote mb-0 card-body "  data-toggle="modal" :data-target="'#note' + note_id " @mouseover="ShowEdit(note.id)" >
                       <strong class='title is-5' type=''>{{note.title}}</strong> 
                        <p class='h6' style="white-space: pre-wrap; word-wrap:break-word ">{{ note.note }}</p>
                 </blockquote>
               </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" :id="'note' + this.note_id " tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
        </div>
     



    </div>
</template>
<script>
export default {
    data(){
        return {
            noteform: false,
            textrow: 2,
            notes: [],
            note_id:''

        }
    },
    methods:{
        createnote(){
            this.noteform=true;
            this.notedisplay=true;
        },
        ExpandTextArea() {
            var el = this.$refs.NoteBody;
            el.style.overflow = 'hidden';
            el.style.height = 0;
            el.style.height = el.scrollHeight + 'px';       
        },
        shownote(){
            axios.get('/note/show').then((response)=>{
                this.notes = response.data
            })
        },
        storenote(){
            if( this.$refs.NoteTitle.value== '' &  this.$refs.NoteBody.value == '')
            {
                  this.noteform=false;
                this.shownote();
            }
            else{
                axios.post('/storenote',{
                    title: this.$refs.NoteTitle.value,
                    note: this.$refs.NoteBody.value,
                }).then(
                    this.$refs.NoteTitle.value='',
                    this.$refs.NoteBody.value='',
                    this.noteform=false,
                    this.shownote(),
                )
            }
            
            
        },
       
        ShowEdit(id){
            this.note_id = id;
        },
     
    },
    mounted() {
        this.shownote();
    }
}
</script>
