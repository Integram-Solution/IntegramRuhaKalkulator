<template>
  <div class="calculator-container flex flex-col">
    <div class="grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-1">
      <div>
        <label for="nev">Név</label><br />
        <input class="border 1px black" type="text" name="nev" id="nev" />
      </div>
      <div>
        <label for="tel">Telefonszám</label><br />
        <input class="border 1px black" type="tel" name="tel" id="tel" />
      </div>
      <div>
        <label for="email">E-mail</label><br />
        <input class="border 1px black" type="text" name="email" id="email" />
      </div>
      <div>
        <label for="cegnev">Cégnév</label><br />
        <input class="border 1px black" type="text" name="cegnev" id="cegnev" />
      </div>
      <div>
        <label for="varos">Város</label><br />
        <input class="border 1px black" type="text" name="varos" id="varos" />
      </div>
      <div>
        <label for="cim">Cím</label><br />
        <input class="border 1px black" type="text" name="cim" id="cim" />
      </div>
      <div>
        <label for="ado">Adószám</label><br />
        <input class="border 1px black" type="text" name="ado" id="ado" />
      </div>
    </div>

    <div class="grid lg:grid-cols-2 grid-cols-1 gap-5">
      <table class="mt-6">
        <thead>
          <tr>
            <th>Termék</th>
            <th>Egységár</th>
            <th>db</th>
            <th>Összesen</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(product, index) in products" :key="index">
            <td>
              <input type="text" v-model="product.name"  class="table-input" />
            </td>
            <td>
              <input type="number" v-model="product.unitPrice" min="0" class="table-input" />
            </td>
            <td>{{ calculateTotalQuantity(index) }}</td>
            <td>{{ calculateTotalPrice(index) }} Ft</td>
          </tr>
        </tbody>
      </table>

      <table class="w-full table-fixed mt-6" id="meretTabla">
        <thead>
          <tr>
            <th>S</th>
            <th>M</th>
            <th>L</th>
            <th>XL</th>
            <th>2XL</th>
            <th>3XL</th>
            <th>4XL</th>
            <th>5XL</th>
            <th>6XL</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(sizes, index) in sizeRows" :key="index">
            <td><input class="table-input" type="number" v-model="sizes.s" min="0" /></td>
            <td><input class="table-input" type="number" v-model="sizes.m" min="0" /></td>
            <td><input class="table-input" type="number" v-model="sizes.l" min="0" /></td>
            <td><input class="table-input" type="number" v-model="sizes.xl" min="0" /></td>
            <td><input class="table-input" type="number" v-model="sizes.xxl" min="0" /></td>
            <td><input class="table-input" type="number" v-model="sizes.xxxl" min="0" /></td>
            <td><input class="table-input" type="number" v-model="sizes.xxxxl" min="0" /></td>
            <td><input class="table-input" type="number" v-model="sizes.xxxxxl" min="0" /></td>
            <td><input class="table-input" type="number" v-model="sizes.xxxxxxl" min="0" /></td>
          </tr>
        </tbody>
      </table>

      <table class="w-20">
        <tr>
          <td>Nettó</td>
          <td><strong>{{ calculateGrandTotal() }} Ft</strong></td>
        </tr>
        <tr>
          <td>Áfa</td>
          <td></td>
        </tr>
        <tr>
          <td>Total</td>
          <td></td>
        </tr>
      </table>

      <table class="w-full" id="kisMeretTabla">
        <tr>
          <td v-for="number in numbers" :key="number">{{ number }}</td>
        </tr>
        <tr>
          <td v-for="number in numbers2" :key="number">{{ number }}</td>
        </tr>
      </table>
    </div>
    <button >PDF letöltése</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      numbers: [],
      numbers2: [],
      products: [
        { name: '', unitPrice: null },
        { name: '', unitPrice: null },
        { name: '', unitPrice: null },
        { name: '', unitPrice: null },
        { name: '', unitPrice: null },
        { name: '', unitPrice: null },
        { name: '', unitPrice: null },
        { name: '', unitPrice: null },
        { name: '', unitPrice: null },
        { name: '', unitPrice: null },
        { name: '', unitPrice: null },
        { name: '', unitPrice: null },
        { name: '', unitPrice: null },
        { name: 'Ing', unitPrice: null },
        { name: 'Cipő', unitPrice: null },
      ],
      sizeRows: [
        { s: "", m: "", l: "", xl: "", xxl: "", xxxl: "", xxxxl: "", xxxxxl: "", xxxxxxl: "" },
        { s: "", m: "", l: "", xl: "", xxl: "", xxxl: "", xxxxl: "", xxxxxl: "", xxxxxxl: "" },
        { s: "", m: "", l: "", xl: "", xxl: "", xxxl: "", xxxxl: "", xxxxxl: "", xxxxxxl: "" },
        { s: "", m: "", l: "", xl: "", xxl: "", xxxl: "", xxxxl: "", xxxxxl: "", xxxxxxl: "" },
        { s: "", m: "", l: "", xl: "", xxl: "", xxxl: "", xxxxl: "", xxxxxl: "", xxxxxxl: "" },
        { s: "", m: "", l: "", xl: "", xxl: "", xxxl: "", xxxxl: "", xxxxxl: "", xxxxxxl: "" },
        { s: "", m: "", l: "", xl: "", xxl: "", xxxl: "", xxxxl: "", xxxxxl: "", xxxxxxl: "" },
        { s: "", m: "", l: "", xl: "", xxl: "", xxxl: "", xxxxl: "", xxxxxl: "", xxxxxxl: "" },
        { s: "", m: "", l: "", xl: "", xxl: "", xxxl: "", xxxxl: "", xxxxxl: "", xxxxxxl: "" },
        { s: "", m: "", l: "", xl: "", xxl: "", xxxl: "", xxxxl: "", xxxxxl: "", xxxxxxl: "" },
        { s: "", m: "", l: "", xl: "", xxl: "", xxxl: "", xxxxl: "", xxxxxl: "", xxxxxxl: "" },
        { s: "", m: "", l: "", xl: "", xxl: "", xxxl: "", xxxxl: "", xxxxxl: "", xxxxxxl: "" },
        { s: "", m: "", l: "", xl: "", xxl: "", xxxl: "", xxxxl: "", xxxxxl: "", xxxxxxl: "" },
        { s: "", m: "", l: "", xl: "", xxl: "", xxxl: "", xxxxl: "", xxxxxl: "", xxxxxxl: "" },
        { s: "", m: "", l: "", xl: "", xxl: "", xxxl: "", xxxxl: "", xxxxxl: "", xxxxxxl: "" },
      ]

    };
  },
  methods: {
    calculateTotalQuantity(index) {
      const sizes = this.sizeRows[index];
      return (
        (parseInt(sizes.s) || 0) +
        (parseInt(sizes.m) || 0) +
        (parseInt(sizes.l) || 0) +
        (parseInt(sizes.xl) || 0) +
        (parseInt(sizes.xxl) || 0) +
        (parseInt(sizes.xxxl) || 0) +
        (parseInt(sizes.xxxxl) || 0) +
        (parseInt(sizes.xxxxxl) || 0) +
        (parseInt(sizes.xxxxxxl) || 0)
      );
    },
    calculateTotalPrice(index) {
      const totalQuantity = this.calculateTotalQuantity(index);
      const unitPrice = parseFloat(this.products[index].unitPrice) || 0;
      return totalQuantity * unitPrice;
    },
    calculateGrandTotal() {
      return this.products.reduce((total, product, index) => {
        return total + this.calculateTotalPrice(index);
      }, 0);
    }
  },
  mounted() {
    for (let i = 39; i <= 50; i++) {
      if (i !== 45 && i !== 47 && i !== 49) {
        this.numbers.push(i);
      }
    }
    for (let i = 38; i <= 46; i++) {
      this.numbers2.push(i);
    }
  },
};
</script>

<style scoped>
.calculator-container {
  @apply flex bg-white sm:w-8/12 w-11/12 h-auto mx-auto rounded-xl p-8;
  margin-top: 10vh;
}

table {
  border-collapse: collapse;
  text-align: center;
  font-size: small;
}
th,
td {
  border: 1px solid black;
}
thead {
  font-size: small;
}
#meretTabla tbody tr:nth-child(14) input {
  background-color: skyblue;
}

#meretTabla tbody tr:nth-child(15) input {
  background-color: lightgray;
}

#kisMeretTabla tr:nth-child(1) {
  background-color: skyblue;
}

#kisMeretTabla tr:nth-child(2) {
  background-color: lightgray;
}

input {
  text-align: center;
}
.table-input {
  width: 100%;
  height: 100%;
  border: none;
  text-align: center;
  box-sizing: border-box;
}

table input[type="number"] {
  -moz-appearance: textfield;
}

table input[type="number"]::-webkit-outer-spin-button,
table input[type="number"]::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>
