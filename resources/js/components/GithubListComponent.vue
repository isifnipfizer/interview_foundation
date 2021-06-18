<template>
    <div>
        <b-row>
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
        </b-row>
        <b-row>
            <b-list-group class="d-none">
                <b-list-group-item></b-list-group-item>
            </b-list-group>
        </b-row>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isDisabled: ($("#gtoken").html().length > 0) ? false : true,
            busy: false
        }
    },
    methods: {
        onClick() {
            this.busy = true;
        },
    },
    mounted: function () { 
        this.$root.$on('tokenAdded', (token) => {
        this.isDisabled = false;
    })
  }
}
</script>
