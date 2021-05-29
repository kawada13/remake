<template>
  <div>
      <h1>練習場aa</h1>
      <div id="app">
        <button v-on:click="doClick">Show!</button>
      </div>
      <hr>
      <div>
          <p v-for="(item, i) in getItems" :key="i">{{item.title}}</p>
      </div>

      <paginate
        :page-count="getPageCount"
        :page-range="3"
        :margin-pages="2"
        :click-handler="clickCallback"
        :prev-text="'＜'"
        :next-text="'＞'"
        :containerClass="'pagination'"
        :page-class="'page-item'"
        :page-link-class="'page-link'"
        :prev-class="'page-item'"
        :prev-link-class="'page-link'"
        :next-class="'page-item'"
        :next-link-class="'page-link'"
        >
      </paginate>

  </div>
</template>

<script>
export default {
    data() {
        return {
            options: {
                duration: 1500,
                type: 'success'
            },
            paginateData: {
                items: [
                    {
                        title: 'test'
                    },
                    {
                        title: 'test2'
                    },
                    {
                        title: 'test3'
                    },
                    {
                        title: 'test4'
                    },
                    {
                        title: 'test5'
                    },
                    {
                        title: 'test6'
                    },
                    {
                        title: 'test7'
                    },
                    {
                        title: 'test8'
                    },
                ],
                parPage: 2,
                currentPage: 1
            }
        }
    },
    methods: {
        doClick(){
        this.$toasted.show('保存しました', this.options);
        },
        clickCallback(pageNum) {
            this.paginateData.currentPage = Number(pageNum);
        }
    },
    computed: {
        getItems() {
        let current = this.paginateData.currentPage * this.paginateData.parPage;
        let start = current - this.paginateData.parPage;
        return this.paginateData.items.slice(start, current);
        },
        getPageCount() {
        return Math.ceil(this.paginateData.items.length / this.paginateData.parPage);
        }
   }



}
</script>

<style>



</style>