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
        opacity="0.6"
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
                axios.post(window.base_url + "addToken", this.$data)
                    .then(response => {
                        this.busy = false
                        this.gtoken = '';
                        this.$root.$emit('tokenAdded', response.data.gtoken)
                        console.log(response);
                        $("#gtoken").html( response.data.gtoken);
                        $("#notoken").hide();
                        $("#formTokenVisibility").addClass('d-none');
                        $("#changeToken").removeClass('d-none');

                    })
                    .catch(error => {
                        this.errors = error.response.data.errors
                        this.busy = false
                    })
        }
    }
}
</script>
