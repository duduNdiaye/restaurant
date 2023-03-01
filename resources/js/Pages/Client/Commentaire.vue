<template>
    <div  @click.self="closeModal()" class="z-50 transform-gpu  fixed top-0 left-0  w-full h-full overflow-x-hidden overflow-y-auto bg-opacity-80 bg-black">
         <div  @click.self="closeModal()"
      class="modal fixed top-0 duration-700 ease-in-out w-full "
    >
      <div class="modal-dialog  mx-auto w-11/12 md:w-2/3 lg:w-1/3 my-12 md:my-24 lg:my-28">
        <div
          class="modal-content relative flex flex-col h-full bg-white shadow-lg rounded-md text-current"
        >
          <div
            class="modal-header h-12 bg-gray-100 flex-shrink-0 items-center justify-between px-4 py-3 border-b border-gray-200 rounded-t-md"
          >
            <h5 class="text-xl font-medium flex items-center justify-center leading-normal text-gray-800">
             Ajouter un commentaire
            </h5>
          </div>
          <div class="modal-body relative flex-1">
            <textarea
              v-model="message"
              class="border-none bg-white focus:ring-white outline-none focus:border-none w-full lg:h-24 lg:w-full h-[3rem]  text-sm focus:outline-none"
              type="text"
              name="commentaire"
              placeholder="Ecrivez votre commentaire ici..."
            />
          </div>
          <div
            class="modal-footer bg-gray-100 flex items-center justify-center px-4 py-3 border-t border-gray-200 rounded-b-md"
          >
            <button @click="Commenter(),closeModal(),fait= true"
              type="button"
              class="px-6 flex w-56 items-center justify-center py-2.5 bg-vert text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-haver hover:shadow-lg focus:bg-haver focus:shadow-lg focus:outline-none focus:ring-0 active:bg-haver active:shadow-lg transition duration-150 ease-in-out "
            >
              Valider
            </button>
          </div>
        </div>
      </div>
    </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            message:null,
            fait:false
        }
    },
  props: {
     comment: {
      type: Boolean,
      required: true
    }
  },

  methods: {
    closeModal() {
      this.$emit("close");
    },
    Commenter()
    {
        this.fait = true
        this.$emit('LeCommentaire',this.message,this.fait);
    }
  },
};
</script>
