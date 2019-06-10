<template>

    <div class="container" >
        <div class="  p-3 mb-5 	box note"  :style="'background:' + SelectedColor" >
                <div class="row"       
                     v-show="noteform">
                     <div v-for="image in images" :key="image.id" class="col-4" >
                        <img :src="image" class="img-fluid"  v-if="image"/>
                     </div>
                    
                </div>
                <div class=" text-warning" v-show="noteform">
                
                    <input type="text" ref="NoteTitle" class="input form-control  " :style="'background:' + SelectedColor" placeholder="Title"> <br>

                </div>  
            <br>
                <div class=" text-warning">            
                    <textarea ref="NoteBody" class="textarea  form-control" :style="'background:' + SelectedColor" rows="1" @click="createnote"  @keydown="ExpandTextArea()" placeholder="Take a note"></textarea>
                    <!-- <input type="text" class="form-control" placeholder="title" > -->   
                </div>
                <br>
                <div v-show="noteform">
                    <input type="file" ref="note_image" @change="onFileChange" />
                </div>

                <!-- <div class="image-upload" v-show="noteform">
                    <label for="file-input">
                        <i class="fas fa-camera"></i>
                    </label>

                    <input id="file-input" type="file"/> 
                </div> -->

               
            <br>
            <div class="row">
                <div class="col-6">
                    <div  v-show="showcolor" class="animated fadeInRight">
                        <button class="selectedcolor" @click=" SelectedColor = '#f28b82' " style="background: #f28b82"></button> &nbsp;
                        <button  class="selectedcolor"  @click=" SelectedColor = '#fbbc04' " style="background: #fbbc04"></button>&nbsp;
                        <button  class="selectedcolor" @click=" SelectedColor = '#fff475' " style="background: #fff475"></button> &nbsp;
                        <button  class="selectedcolor" @click=" SelectedColor = '#ccff90' " style="background: #ccff90"></button> &nbsp;
                        <button  class="selectedcolor" @click=" SelectedColor = '#a7ffeb' " style="background: #a7ffeb"></button> &nbsp;
                        <button  class="selectedcolor" @click=" SelectedColor = '#cbf0f8' " style="background: #cbf0f8"></button> &nbsp;
                        <button  class="selectedcolor" @click=" SelectedColor = '#aecbfa' " style="background: #aecbfa"></button> &nbsp;
                        <button class="selectedcolor" @click=" SelectedColor = '#d7aefb' " style="background: #d7aefb"> </button> &nbsp;              
                    </div>
                </div>
                 <div class="col-6 justify-content-right">
                    <button class="btn" v-show="noteform" @click="colortab()" title="Choose Color"><i class="fas fa-palette"></i></button>
                    <button class="btn" v-show="noteform" @click="colortab()" title="Make To Do list"><i class="far fa-check-square"></i></button>
                    <button class="btn " :style="'background:' + SelectedColor" v-show="noteform" @click="storenote()">Close</button>                     
                 </div>
                          

            </div>
        </div> <br>

        <div class="container " >
           <div class=" card-columns">  
                <div class="card p-3 box box-shadow" 
                    v-for="note in notes" :key='note.id' 
                    :style="'background:' + note.color" >
                    <blockquote class="blockquote mb-0 card-body "  data-toggle="modal" :data-target="'#note' + note_id " @mouseover="ShowEdit(note.id)" @click="Editdata(note.id)">
                       <strong class='title is-5' type=''>{{note.title}}</strong> 
                        <p class='h6' style="white-space: pre-wrap; word-wrap:break-word ">{{ note.note }}</p>
                    </blockquote>
               </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" 
            :id="'note' + this.note_id " 
            tabindex="-1" role="dialog" 
            aria-labelledby="exampleModalCenterTitle" 
            aria-hidden="true"
             >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content"  :style="'background:' + SelectedNotes.color">
                    <div class="">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="text" 
                                ref="NoteUpdatetitle" 
                                class="input form-control " 
                                :value="SelectedNotes.title"
                                :style="'background:' + SelectedNotes.color"> <br>

                        <textarea ref="NoteUpdatenote"
                                    class="textarea  form-control"  
                                    rows="5" 
                                    @keydown="ExpandTextArea()" 
                                    :value="SelectedNotes.note"
                                    :style="'background:' + SelectedNotes.color"></textarea>
                    </div>
                    <div class="">
                        <button type="button" class="btn " 
                                @click="updatenote(SelectedNotes.id)" 
                                data-dismiss="modal"
                                :style="'background:' + SelectedNotes.color">Close</button>
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
            SelectedColor : '#fbbc04',
            noteform: false,
            textrow: 2,
            notes: [],
            note_id:'',
            SelectedNotes:[],
            showcolor: false,
            images:[],

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
            if( this.$refs.NoteTitle.value== '' &  this.$refs.NoteBody.value == '' & this.images.length ==0)
            {
                this.noteform=false;
                this.images = [ ]
                this.$refs.note_image.value= '',
                this.showcolor= false,
                this.shownote();
            }
            else{
                axios.post('/storenote',{
                    title: this.$refs.NoteTitle.value,
                    note: this.$refs.NoteBody.value,
                    color: this.SelectedColor,
                    image: this.images,
                }).then(
                    this.$refs.NoteTitle.value='',
                    this.$refs.NoteBody.value='',
                    this.$refs.note_image.value= '',
                    this.noteform=false,
                     this.showcolor= false,
                    this.images =[ ],
                    this.shownote(),
                )
            }
            
            
        },
       
        ShowEdit(id){
            this.note_id = id;
            
        },
        Editdata(id){
                axios.get('/note/edit/'+id ).then((response)=>{
                this.SelectedNotes = response.data
            })
        },
           updatenote(id){
                axios.post('/note/update/'+id ,{
                    title: this.$refs.NoteUpdatetitle.value,
                    note: this.$refs.NoteUpdatenote.value,
                }).then((response)=>{
                this.shownote()
            })
        },
        colortab(){
            this.showcolor = true;
        },
         onFileChange(e) {
               var selectedfile = URL.createObjectURL(this.$refs.note_image.files[0]);
                this.images.push(selectedfile);
            }

     
    },
    mounted() {
        this.shownote();
    }
}
</script>
