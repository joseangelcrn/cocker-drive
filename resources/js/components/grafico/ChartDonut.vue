<template>
  <vc-donut
    background="white" foreground="grey"
    :size="300" unit="px" :thickness="30"
    has-legend  legend-placement="bottom"
    :sections="sections" :total="100"
    :start-angle="0" :auto-adjust-text-size="true"
    @section-click="handleSectionClick">
    <label>Espacio usado</label>
    <h3>{{parsedTotalSize.amount}} {{parsedTotalSize.type}}</h3>
  </vc-donut>
</template>

<script>
  export default {
    props:['data_param','size_disk_used'],
    data() {
      return {
        sections: []
      };
    },
    beforeMount(){
        this.sections = JSON.parse(this.$props.data_param);
    },
    methods: {
      handleSectionClick(section, event) {
        console.log(`${section.label} clicked.`);
      }
    },
    computed:{
        //check if is possible parse  used disk to GB
        parsedTotalSize(){
            //init size on MB

            let result = {amount:this.$props.size_disk_used,type:'MB'};
            //parse to GB
            let sizeToGB = this.$props.size_disk_used/1024;

            //there is, at least, 1 gb of memory
            if (sizeToGB >= 1) {
                result.amount =(Math.round(sizeToGB * 100) / 100).toFixed(2);
                result.type = 'GB';
            }

            return result;
        }
    }
  };
</script>
