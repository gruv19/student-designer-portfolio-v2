<template>
  <div @dragover.prevent @drop.prevent @dragenter.prevent @dragleave.prevent class="file-input">
    <input
      type="file"
      ref="input"
      v-if="multiple"
      multiple
      @change="uploadFiles"
      class="file-input__input"
    />
    <input
      type="file"
      ref="input"
      v-else
      @change="uploadFiles"
      class="file-input__input"
     />
    <div
      @drop.prevent="dropFiles"
      @click="changeFileInput"
      class="file-input__gragarea"
      :class="!files.length ? 'file-input__gragarea--empty' : ''"
    >
      <p
        v-if="!imagesForRender.length"
        class="file-input__placeholder"
      >{{ plcHolder }}</p>
      <div
        v-else
        class="file-input__preview"
        :class="multiple ? 'file-input__preview--multiple' : ''"
      >
        <img v-for="img in imagesForRender" :src="img" :key="img">
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'FileInput',
  props: {
    multiple: {
      type: Boolean,
      default: false,
    },
    plcHolder: {
      required: true,
      type: String,
    },
    editedImages: {
      type: Array,
    },
  },
  data() {
    return {
      files: [],
      images: [],
    };
  },
  computed: {
    imagesForRender() {
      if (this.editedImages.length && !this.images.length) {
        return this.editedImages;
      }
      return this.images;
    },
  },
  methods: {
    changeFileInput() {
      this.$refs.input.click();
    },
    uploadFiles(e) {
      this.files = [...e.target.files];
      this.images = this.files.map((file) => URL.createObjectURL(file));
      if (this.multiple) {
        this.$emit('filesUpload', this.files);
      } else {
        this.$emit('onefileUpload', this.files[0]);
      }
    },
    dropFiles(e) {
      this.files = [...e.dataTransfer.files];
      this.images = this.files.map((file) => URL.createObjectURL(file));
      if (this.multiple) {
        this.$emit('filesUpload', this.files);
      } else {
        this.$emit('onefileUpload', this.files[0]);
      }
    },
  },
};
</script>
