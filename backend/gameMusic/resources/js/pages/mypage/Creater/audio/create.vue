<template>
  <div>
   <div class="head">
      <h4>商品登録</h4>
    </div>


    <div class="form_creater_edit my-5">
      <div class="card">
        <div class="card-body">
          <form @submit.prevent="update">

            <div class="form-group">
              <div><label for="title">タイトル<span class="badge badge-danger">必須</span></label></div>
              <input type="text" class="form-control form-control-lg" id="title" v-model="title">
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.title.required">
                入力は必須です！
              </div>
            </div>

            <div class="form-group">
              <div><label for="price">価格<span class="badge badge-danger">必須</span></label></div>
              <input type="number" class="form-control form-control-lg" id="price" v-model="price">
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.price.required">
                入力は必須です！
              </div>
            </div>

            <div class="form-group">
              <div><label for="branch_name">支店名<span class="badge badge-danger">必須</span></label></div>
              <input type="text" class="form-control form-control-lg" id="branch_name" v-model="branch_name">
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.branch_name.required">
                入力は必須です！
              </div>
            </div>

            <div class="form-group">
              <div><label for="branch_code">支店コード<span class="badge badge-danger">必須</span></label></div>
              <input type="number" class="form-control form-control-lg" id="branch_code" v-model="branch_code">
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.branch_code.required">
                入力は必須です！
              </div>
            </div>

            <div class="form-group">
              <div><label>預金種別<span class="badge badge-danger">必須</span></label></div>
              <div class="d-flex justify-content-start">
                <div class="form-check mr-2">
                <input class="form-check-input" type="radio" name="radio1" id="radio1a" checked v-model="deposit_type" value="普通">
                <label class="form-check-label" for="radio1a">普通</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="radio1" id="radio1b" v-model="deposit_type" value="当座">
                  <label class="form-check-label" for="radio1b">当座</label>
                </div>
              </div>
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.deposit_type.required">
                選択は必須です！
              </div>
            </div>

            <div class="form-group">
              <div><label for="account_number">口座番号<span class="badge badge-danger">必須</span></label></div>
              <input type="number" class="form-control form-control-lg" id="account_number" v-model="account_number">
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.account_number.required">
                入力は必須です！
              </div>
            </div>

            <div class="form-group">
              <div><label for="account_holder">口座名義（全角カタカナ）<span class="badge badge-danger">必須</span></label></div>
              <input type="text" class="form-control form-control-lg" id="account_holder" v-model="account_holder">
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.account_holder.required">
                入力は必須です！
              </div>
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.account_holder.katakana">
                全角カタカナのみです！
              </div>
            </div>

            <button type="submit" class="btn btn-primary my-4 store mr-5">保存<i class="fas fa-chevron-right pl-2"></i></button>
            <button type="submit" class="btn btn-primary my-4 cancel">キャンセル</button>
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
      errors: {
        title: {
          required: false,
        },
        price: {
          required: false,
        },
        branch_name: {
          required: false,
        },
        branch_code: {
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
      title: '',
      price: '',
      branch_name: '',
      branch_code: '',
      deposit_type: '',
      account_number: '',
      account_holder: '',
    }
  },

}
</script>


<style scoped>
.head h4 {
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