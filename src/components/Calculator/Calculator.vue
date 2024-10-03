<template>
  <div class="calculator-container flex flex-col">
    <div class="grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-1">
      <div>
        <label for="nev">Név</label><br />
        <input class="border" type="text" name="nev" id="nev" />
      </div>
      <div>
        <label for="tel">Telefonszám</label><br />
        <input class="border" type="tel" name="tel" id="tel" />
      </div>
      <div>
        <label for="email">E-mail</label><br />
        <input class="border" type="email" name="email" id="email" />
      </div>
      <div>
        <label for="cegnev">Cégnév</label><br />
        <input class="border" type="text" name="cegnev" id="cegnev" />
      </div>
      <div>
        <label for="varos">Város</label><br />
        <input class="border" type="text" name="varos" id="varos" />
      </div>
      <div>
        <label for="cim">Cím</label><br />
        <input class="border" type="text" name="cim" id="cim" />
      </div>
      <div>
        <label for="ado">Adószám</label><br />
        <input class="border" type="text" name="ado" id="ado" />
      </div>
    </div>

    <div id="element-to-convert">
      <div id="form-data" class="flex-container">
        <div class="left-column">
          <!-- Bal oldali adatok -->
        </div>
        <div class="right-column">
          <!-- Jobb oldali adatok -->
        </div>
      </div>
      <div class="grid lg:grid-cols-2 grid-cols-1 gap-5">
        <div>
          <table class="elsotablak mt-6" id="seged">
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
                  <input
                    type="text"
                    v-model="product.name"
                    class="table-input"
                  />
                </td>
                <td class="w-20">
                  <input
                    type="number"
                    v-model.number="product.unitPrice"
                    min="0"
                    class="table-input"
                  />
                </td>
                <td class="w-12">{{ calculateTotalQuantity(index) }}</td>
                <td class="w-20">{{ calculateTotalPrice(index) }} Ft</td>
              </tr>
            </tbody>
          </table>
          <table class="elsotablak w-full mt-5" id="osszegTabla">
            <tr>
              <td></td>
              <td></td>
              <td class="w-12"><strong>Nettó</strong></td>
              <td class="w-20">
                <strong>{{ calculateGrandTotal() }} Ft</strong>
              </td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td>Áfa</td>
              <td>{{ calculateVAT() }} Ft</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td>Total</td>
              <td>{{ calculateTotalWithVAT() }} Ft</td>
            </tr>
          </table>
        </div>
        <div>
          <table class="masodiktablak w-fit mt-6" id="meretTabla">
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
                <template v-if="index === 11 || index === 12">
                  <td colspan="9">
                    <input
                      class="table-input"
                      type="number"
                      v-model="sizes.s"
                      min="0"
                    />
                  </td>
                </template>
                <template v-else>
                  <td>
                    <input
                      class="table-input"
                      type="number"
                      v-model="sizes.s"
                      min="0"
                    />
                  </td>
                  <td>
                    <input
                      class="table-input"
                      type="number"
                      v-model="sizes.m"
                      min="0"
                    />
                  </td>
                  <td>
                    <input
                      class="table-input"
                      type="number"
                      v-model="sizes.l"
                      min="0"
                    />
                  </td>
                  <td>
                    <input
                      class="table-input"
                      type="number"
                      v-model="sizes.xl"
                      min="0"
                    />
                  </td>
                  <td>
                    <input
                      class="table-input"
                      type="number"
                      v-model="sizes.xxl"
                      min="0"
                    />
                  </td>
                  <td>
                    <input
                      class="table-input"
                      type="number"
                      v-model="sizes.xxxl"
                      min="0"
                    />
                  </td>
                  <td>
                    <input
                      class="table-input"
                      type="number"
                      v-model="sizes.xxxxl"
                      min="0"
                    />
                  </td>
                  <td>
                    <input
                      class="table-input"
                      type="number"
                      v-model="sizes.xxxxxl"
                      min="0"
                    />
                  </td>
                  <td>
                    <input
                      class="table-input"
                      type="number"
                      v-model="sizes.xxxxxxl"
                      min="0"
                    />
                  </td>
                </template>
              </tr>
            </tbody>
          </table>
          <table class="masodiktablak w-full mt-5" id="kisMeretTabla">
            <tr>
              <td v-for="number in numbers" :key="number">{{ number }}</td>
            </tr>
            <tr>
              <td v-for="number in numbers2" :key="number">{{ number }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <button class="mt-5 mx-auto" @click="exportToPDF">PDF letöltése</button>
  </div>
</template>

<script>
import html2pdf from "html2pdf.js";
export default {
  data() {
    return {
      numbers: [],
      numbers2: [],
      products: [
        { name: "", unitPrice: null },
        { name: "", unitPrice: null },
        { name: "", unitPrice: null },
        { name: "", unitPrice: null },
        { name: "", unitPrice: null },
        { name: "", unitPrice: null },
        { name: "", unitPrice: null },
        { name: "", unitPrice: null },
        { name: "", unitPrice: null },
        { name: "", unitPrice: null },
        { name: "", unitPrice: null },
        { name: "", unitPrice: null },
        { name: "", unitPrice: null },
        { name: "Ing", unitPrice: null },
        { name: "Cipő", unitPrice: null },
      ],
      sizeRows: [
        {
          s: "",
          m: "",
          l: "",
          xl: "",
          xxl: "",
          xxxl: "",
          xxxxl: "",
          xxxxxl: "",
          xxxxxxl: "",
        },
        {
          s: "",
          m: "",
          l: "",
          xl: "",
          xxl: "",
          xxxl: "",
          xxxxl: "",
          xxxxxl: "",
          xxxxxxl: "",
        },
        {
          s: "",
          m: "",
          l: "",
          xl: "",
          xxl: "",
          xxxl: "",
          xxxxl: "",
          xxxxxl: "",
          xxxxxxl: "",
        },
        {
          s: "",
          m: "",
          l: "",
          xl: "",
          xxl: "",
          xxxl: "",
          xxxxl: "",
          xxxxxl: "",
          xxxxxxl: "",
        },
        {
          s: "",
          m: "",
          l: "",
          xl: "",
          xxl: "",
          xxxl: "",
          xxxxl: "",
          xxxxxl: "",
          xxxxxxl: "",
        },
        {
          s: "",
          m: "",
          l: "",
          xl: "",
          xxl: "",
          xxxl: "",
          xxxxl: "",
          xxxxxl: "",
          xxxxxxl: "",
        },
        {
          s: "",
          m: "",
          l: "",
          xl: "",
          xxl: "",
          xxxl: "",
          xxxxl: "",
          xxxxxl: "",
          xxxxxxl: "",
        },
        {
          s: "",
          m: "",
          l: "",
          xl: "",
          xxl: "",
          xxxl: "",
          xxxxl: "",
          xxxxxl: "",
          xxxxxxl: "",
        },
        {
          s: "",
          m: "",
          l: "",
          xl: "",
          xxl: "",
          xxxl: "",
          xxxxl: "",
          xxxxxl: "",
          xxxxxxl: "",
        },
        {
          s: "",
          m: "",
          l: "",
          xl: "",
          xxl: "",
          xxxl: "",
          xxxxl: "",
          xxxxxl: "",
          xxxxxxl: "",
        },
        {
          s: "",
          m: "",
          l: "",
          xl: "",
          xxl: "",
          xxxl: "",
          xxxxl: "",
          xxxxxl: "",
          xxxxxxl: "",
        },
        {
          s: "",
          m: "",
          l: "",
          xl: "",
          xxl: "",
          xxxl: "",
          xxxxl: "",
          xxxxxl: "",
          xxxxxxl: "",
        },
        {
          s: "",
          m: "",
          l: "",
          xl: "",
          xxl: "",
          xxxl: "",
          xxxxl: "",
          xxxxxl: "",
          xxxxxxl: "",
        },
        {
          s: "",
          m: "",
          l: "",
          xl: "",
          xxl: "",
          xxxl: "",
          xxxxl: "",
          xxxxxl: "",
          xxxxxxl: "",
        },
        {
          s: "",
          m: "",
          l: "",
          xl: "",
          xxl: "",
          xxxl: "",
          xxxxl: "",
          xxxxxl: "",
          xxxxxxl: "",
        },
      ],
    };
  },
  methods: {
    formatPriceWithFt(value) {
      if (!value) return "";
      const number = parseFloat(value);

      return number.toLocaleString("hu-HU") + " Ft";
    },
    updatePrice(event, index) {
      const rawValue = event.target.value
        .replace(/\./g, "")
        .replace(/,/g, ".")
        .replace(" Ft", "");
      if (!isNaN(rawValue) && rawValue !== "") {
        this.products[index].unitPrice = parseFloat(rawValue);
      } else {
        this.products[index].unitPrice = 0;
      }
    },
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
    },
    calculateVAT() {
      const vat = this.calculateGrandTotal() * 0.27;
      return this.roundToNearestFive(vat);
    },
    formatNumberWithSeparator(value) {
      return value.toLocaleString("hu-HU");
    },

    roundToNearestFive(value) {
      return Math.round(value / 5) * 5;
    },
    calculateTotalWithVAT() {
      return this.calculateGrandTotal() + this.calculateVAT();
    },
    exportToPDF() {
      const nev = document.getElementById("nev").value;
      const email = document.getElementById("email").value;
      const tel = document.getElementById("tel").value;
      const cegnev = document.getElementById("cegnev").value;
      const varos = document.getElementById("varos").value;
      const cim = document.getElementById("cim").value;
      const ado = document.getElementById("ado").value;

      const rightColumnData = `<p>Név: ${nev}</p><p>Email: ${email}</p><p>Telefonszám: ${tel}</p>`;

      const leftColumnData = `<p>Cégnév: ${cegnev}</p><p>Város: ${varos}</p><p>Cím: ${cim}</p><p>Adószám: ${ado}</p>`;

      document.querySelector(".left-column").innerHTML = leftColumnData;
      document.querySelector(".right-column").innerHTML = rightColumnData;
      html2pdf(document.getElementById("element-to-convert"), {
        margin: 1,
        filename: "integram-ruha-" + Date.now() + ".pdf",
        image: { type: "jpeg", quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: "cm", format: "a4", orientation: "landscape" },
      }).then(() => {
        document.getElementById("form-data").innerHTML = "";
      });;
    },
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
.flex-container {
  display: flex;
  justify-content: space-between;
  font-family: Helvetica;
}

.calculator-container {
  @apply flex bg-white sm:w-8/12 w-11/12 h-auto mx-auto rounded-xl sm:p-8 p-2;
  margin-top: 10vh;
  font-family: Helvetica;
}

.elsotablak td {
  border: 1px solid gray;
  border-radius: 15px;
}

.elsotablak th {
  border: 1px solid black;
  border-radius: 15px;
}

.elsotablak td:nth-child(1) {
  border: 1px solid black;
  border-radius: 15px;
}

.masodiktablak td {
  border: 1px solid grey;
  border-radius: 5px;
}

.masodiktablak th {
  border: 1px solid black;
  border-radius: 5px;
}

button {
  background-color: #4bb543;
  border-radius: 15px;
  width: fit-content;
  padding: 0 5px 0 5px;
}

#osszegTabla tr td:nth-child(3) {
  border: solid 1px black;
}

table {
  border-collapse: separate;
  border-spacing: 3px;
  text-align: center;
  font-size: small;
  table-layout: fixed;
  font-family: Helvetica;
}

#seged {
  width: 100%;
  table-layout: auto;
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

#kisMeretTabla td {
  border: 1px solid black;
}

.elsotablak input {
  text-align: center;
  border-radius: 15px;
}

.masodiktablak input {
  text-align: center;
  border-radius: 5px;
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

#osszegTabla td:empty {
  border: none;
}
</style>
