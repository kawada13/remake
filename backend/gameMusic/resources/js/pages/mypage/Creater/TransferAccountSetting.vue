<template>
  <div class="">
    <div class="title">
      <h4>振込口座設定</h4>
    </div>


    <div class="form_creater_edit my-5">
      <div class="card">
        <div class="card-body">
          <form @submit.prevent="update">

            <div class="form-group">
              <div><label for="bank_name">銀行名<span class="badge badge-danger ml-2">必須</span></label></div>
              <input type="text" class="form-control form-control-lg" id="bank_name" v-model="form.bank_name">
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.bank_name.required">
                入力は必須です！
              </div>
            </div>

            <div class="form-group">
              <div><label for="bank_code">銀行コード<span class="badge badge-danger ml-2">必須</span></label></div>
              <input type="number" class="form-control form-control-lg" id="bank_code" v-model="form.bank_code">
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.bank_code.required">
                入力は必須です！
              </div>
            </div>

            <div class="form-group">
              <div><label for="branch_name">支店名<span class="badge badge-danger ml-2">必須</span></label></div>
              <input type="text" class="form-control form-control-lg" id="branch_name" v-model="form.branch_name">
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.branch_name.required">
                入力は必須です！
              </div>
            </div>

            <div class="form-group">
              <div><label for="branch_number">支店コード<span class="badge badge-danger ml-2">必須</span></label></div>
              <input type="number" class="form-control form-control-lg" id="branch_number" v-model="form.branch_number">
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.branch_number.required">
                入力は必須です！
              </div>
            </div>

            <div class="form-group">
              <div><label>預金種別<span class="badge badge-danger ml-2">必須</span></label></div>
              <div class="d-flex justify-content-start">
                <div class="form-check mr-2">
                <input class="form-check-input" type="radio" name="radio1" id="radio1a" checked v-model="form.deposit_type" value="普通">
                <label class="form-check-label" for="radio1a">普通</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="radio1" id="radio1b" v-model="form.deposit_type" value="当座">
                  <label class="form-check-label" for="radio1b">当座</label>
                </div>
              </div>
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.deposit_type.required">
                選択は必須です！
              </div>
            </div>

            <div class="form-group">
              <div><label for="account_number">口座番号<span class="badge badge-danger ml-2">必須</span></label></div>
              <input type="number" class="form-control form-control-lg" id="account_number" v-model="form.account_number">
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.account_number.required">
                入力は必須です！
              </div>
            </div>

            <div class="form-group">
              <div><label for="account_holder">口座名義（全角カタカナ）<span class="badge badge-danger ml-2">必須</span></label></div>
              <input type="text" class="form-control form-control-lg" id="account_holder" v-model="form.account_holder">
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.account_holder.required">
                入力は必須です！
              </div>
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.account_holder.katakana">
                全角カタカナのみです！
              </div>
            </div>

            <button type="submit" class="btn btn-primary my-4 store mr-5">保存<i class="fas fa-chevron-right pl-2"></i></button>
            <button type="button" class="btn btn-primary my-4 cancel">キャンセル</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loading: false,
      errors: {
        bank_name: {
          required: false,
        },
        bank_code: {
          required: false,
        },
        branch_name: {
          required: false,
        },
        branch_number: {
          required: false,
        },
        deposit_type: {
          required: false,
        },
        account_number: {
          required: false,
        },
        account_holder: {
          required: false,
          katakana: false
        },
      },
      form: {
        bank_name: '',
        bank_code: '',
        branch_name: '',
        branch_number: '',
        deposit_type: '',
        account_number: '',
        account_holder: '',
      },
      options: { //トースト用オプション
          duration: 1500,
          type: 'success'
      },
      
    }
  },
  methods: {
    async update() {
      this.validate();
      // 何か一つでもバリデーションにひっかがっていたらアップデートさせない
      if(this.errors.bank_name.required || this.errors.bank_code.required || this.errors.branch_name.required || this.errors.branch_number.required || this.errors.deposit_type.required || this.errors.account_number.required || this.errors.account_holder.required || this.errors.account_holder.katakana)
      {
        return
      }
      console.log('アップデーt');
      try {
        this.loading = true
        await this.$store.dispatch('transferAccount/create', this.form)
      }
      catch(e){
        console.log(e);
        this.loading = false
      }
      finally{
        this.loading = false
        this.toasted()
      }
    },
    toasted() {
      this.$toasted.show('保存しました', this.options);
    },
    validate() {

      // 一旦初期化
      this.errors = {
        bank_name: {
          required: false,
        },
        bank_code: {
          required: false,
        },
        branch_name: {
          required: false,
        },
        branch_number: {
          required: false,
        },
        deposit_type: {
          required: false,
        },
        account_number: {
          required: false,
        },
        account_holder: {
          required: false,
          katakana: false
        }
      }

      // 必須チェック
      if (!this.form.bank_name) {
        this.errors.bank_name.required = true
      }
      if (!this.form.bank_code) {
        this.errors.bank_code.required = true
      }
      if (!this.form.branch_name) {
        this.errors.branch_name.required = true
      }
      if (!this.form.branch_number) {
        this.errors.branch_number.required = true
      }
      if (!this.form.deposit_type) {
        this.errors.deposit_type.required = true
      }
      if (!this.form.account_number) {
        this.errors.account_number.required = true
      }
      if (!this.form.account_holder) {
        this.errors.account_holder.required = true
      }

      // 全角カタカナチェック
      if (this.form.account_holder.match(/^[ァ-ヶー　]+$/)) {
        this.errors.account_holder.katakana = false
      } else {
        this.errors.account_holder.katakana = true
      }
    }
  },

}
</script>

<style scoped>
.title h4 {
  font-weight: bold;
}
.store{
  color: white;
  font-weight: bold;
  padding: 12px 30px;
  border-radius: 20px;
}
.cancel{
  color: white;
  font-weight: bold;
  padding: 12px 30px;
  border-radius: 20px;
  background: #4DB7FE;
}

</style>