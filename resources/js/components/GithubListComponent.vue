<template>
    <div>
        <b-row>
            <b-col cols="4">
            <b-overlay
        :show="busy"
        opacity="0.8"
        >
        <template #overlay>
        <div class="d-flex align-items-center d-inline-block">
          <b-spinner small type="grow" variant="secondary"></b-spinner>
          <b-spinner small type="grow" variant="secondary"></b-spinner>
          <span >Getting your data...</span>
        </div>
        </template>
            <b-button id="starButton" :disabled="isDisabled" variant="info" @click="onClick">Get Starred Repositories</b-button>
        </b-overlay>
            </b-col>
            <b-col cols="4">
         <b-toast id="message-toast" :title="messageTitle" static :variant="variant">
                {{ message }}
        </b-toast>
            </b-col>
        </b-row>
        <b-row class="mt-3">
            
            <b-col cols="12">
            <b-list-group v-bind:class="{ 'd-none': isHidden, }" id="repoListGroup">
                Repositories List:
                <b-list-group-item v-for="(repo, index) in repos" :key="index">
                    {{index}} {{repo.full_name}} <a :href="repo.html_url" target="_blank">Go to Repo</a>
                </b-list-group-item>
            </b-list-group>
            </b-col>
        </b-row>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isDisabled: ($("#gtoken").html().length > 0) ? false : true,
            busy: false,
            message: '',
            messageTitle: '',
            variant: 'danger',
            repos: '',
            isHidden: true
        }
    },
    methods: {
        onClick() {
            this.busy = true
            this.isDisabled = true
            this.getStarRepos()
        },
         async getStarRepos() {
             let axiosConfig = {
                headers: {
                    "Access-Control-Allow-Origin": "*",
                    "Access-Control-Allow-Credentials": true,
                    Authorization: 'Bearer ' + Laravel.apiToken
                }
             };
             let data = null;
                axios.post(Laravel.base_url + "api/getGithubStarRepos",data,axiosConfig)
                    .then(response => {
                        this.busy = false
                        this.isDisabled = false
                        console.log(response);
                        if(response.data.length>0){
                            this.repos = response.data
                            this.isHidden = false;
                        }else{
                            this.message = 'No star repositories found'
                            this.messageTitle = 'Info'
                            this.variant = 'info';
                            this.$bvToast.show('message-toast')
                        }
                    })
                    .catch(error => {
                        this.message = error.response.data.error_message
                        this.messageTitle = 'Error'
                        this.variant = 'danger';
                        this.busy = false
                        this.isDisabled = false
                        this.$bvToast.show('message-toast')
                    })
        }
    },
    mounted: function () { 
        this.$root.$on('tokenAdded', (token) => {
        this.isDisabled = false;
    })
  }
}
</script>
