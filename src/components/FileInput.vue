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
        v-if="!files.length"
        class="file-input__placeholder"
      >{{ plcHolder }}</p>
      <div
        v-else
        class="file-input__preview"
        :class="multiple ? 'file-input__preview--multiple' : ''"
      >
        <img v-for="img in images" :src="img" :key="img">
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
  },
  data() {
    return {
      files: [],
      images: [],
    };
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
