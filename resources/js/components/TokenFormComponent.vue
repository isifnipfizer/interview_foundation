<template>
    <b-form @submit.prevent="onSubmit">
        <span class="help is-danger" v-text="errors"></span>
        <b-form-group
        id="gtoken-group"
        >
            <b-form-input type="text" class="form-control" name="gtoken" id="gtoken" placeholder="Enter token" required v-model="gtoken"></b-form-input>
        </b-form-group>
        <b-overlay
        :show="busy"
        rounded
        opacity="0.6"
        spinner-small
        spinner-variant="primary"
        class="d-inline-block"
        >
        <template #overlay>
        <div class="d-flex align-items-center">
          <b-spinner small type="grow" variant="secondary"></b-spinner>
          <b-spinner small type="grow" variant="secondary"></b-spinner>
          <span >Saving...</span>
        </div>
        </template>
        <b-button type="submit" :disabled="busy" variant="dark">Save token</b-button>
        </b-overlay>
    </b-form>
</template>

<script>
export default {
        data() {
            return {
                busy: false,
                timeout: null,
                gtoken: '',
                errors: ''
            }
        },
        methods: {
            onSubmit() {
                this.busy = true
                this.addToken()
            },
            async addToken() {
                //axios.defaults.headers.common['Authorization'] = `Bearer ${this.$auth.getAccessToken()}`
                //axios.post(API_BASE_URL + '{{url(addToken', this.$data)
                axios.post(window.base_url + "addToken", this.$data)
                    .then(response => {
                        this.busy = false
                        this.gtoken = '';
                        //this.$emit('completed', response.data.gtoken)
                        console.log(response);
                        $("#gtoken").html( response.data.gtoken);
                        $("#notoken").hide();
                        $("#formTokenVisibility").toggleClass('d-none');

                    })
                    .catch(error => {
                        // handle authentication and validation errors here
                        this.errors = error.response.data.errors
                        this.busy = false
                    })
        }
    }
}
</script>