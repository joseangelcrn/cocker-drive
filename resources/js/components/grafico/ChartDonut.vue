<template>
  <vc-donut
    background="white" foreground="grey"
    :size="300" unit="px" :thickness="30"
    has-legend  legend-placement="bottom"
    :sections="sections" :total="100"
    :start-angle="0" :auto-adjust-text-size="true"
    @section-click="handleSectionClick">
    <label>Espacio usado</label>
    <h3>{{size_disk_used}}MB</h3>
  </vc-donut>
</template>

<script>
  export default {
    props:['data_param','size_disk_used'],
    data() {
      return {
        sections: [
          { label: 'Red section', value: 25 },
          { label: 'Green section', value: 25},
          { label: 'Blue section', value: 25}
        ]
      };
    },
    beforeMount(){
        this.sections = JSON.parse(this.$props.data_param);
    },
    methods: {
      handleSectionClick(section, event) {
        console.log(`${section.label} clicked.`);
      }
    }
  };
</script>
