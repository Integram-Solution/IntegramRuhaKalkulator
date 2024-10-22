<template>
  <div class="calculator-container flex flex-col">
    <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1">
      <div class="px-2">
        <div>
          <label for="cegnev">Cégnév</label><br />
          <input
            class="border w-full rounded-xl"
            type="text"
            name="cegnev"
            id="cegnev"
          />
        </div>
        <div>
          <label for="cim">Cím</label><br />
          <input
            class="border w-full rounded-xl"
            type="text"
            name="cim"
            id="cim"
          />
        </div>
        <div>
          <label for="ado">Adószám</label><br />
          <input
            class="border w-full rounded-xl"
            type="text"
            name="ado"
            id="ado"
          />
        </div>
      </div>
      <div class="px-2">
        <div>
          <label for="nev">Név</label><br />
          <input
            class="border w-full rounded-xl"
            type="text"
            name="nev"
            id="nev"
          />
        </div>
        <div>
          <label for="tel">Telefonszám</label><br />
          <input
            class="border w-full rounded-xl"
            type="tel"
            name="tel"
            id="tel"
          />
        </div>
        <div>
          <label for="email">E-mail</label><br />
          <input
            class="border w-full rounded-xl"
            type="email"
            name="email"
            id="email"
          />
        </div>
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
      <div class="grid custom-cols lg:grid-cols-2 grid-cols-1 gap-5">
        <div>
          <table class="elsotablak mt-6" id="seged">
            <thead>
              <tr>
                <th>Termék</th>
                <th class="w-1/5">Egységár</th>
                <th class="w-1/12">db</th>
                <th class="w-1/5">Összesen</th>
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
                <td>
                  <input
                    type="text"
                    :value="formattedPrices[index]"
                    @input="updatePrice($event, index)"
                    @blur="formatPrice($event, index)"
                    class="table-input"
                  />
                </td>

                <td>{{ calculateTotalQuantity(index) }}</td>
                <td>
                  {{ formatNumberWithSeparator(calculateTotalPrice(index)) }} Ft
                </td>
              </tr>
            </tbody>
          </table>
          <table class="elsotablak w-full mt-5" id="osszegTabla">
            <tr>
              <td></td>
              <td></td>
              <td class="w-1/5"><strong>Nettó</strong></td>
              <td class="w-2/4">
                <strong
                  >{{
                    formatNumberWithSeparator(calculateGrandTotal())
                  }}
                  Ft</strong
                >
              </td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td>Áfa</td>
              <td>{{ formatNumberWithSeparator(calculateVAT()) }} Ft</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td>Total</td>
              <td>
                {{ formatNumberWithSeparator(calculateTotalWithVAT()) }} Ft
              </td>
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
          <table class="w-full mt-5" id="kisMeretTabla">
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
      formattedPrices: [],
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
      return number.toLocaleString("en-HU") + " Ft";
    },
    updatePrice(event, index) {
      const rawValue = event.target.value
        .replace(/\s/g, "")
        .replace(/\./g, "")
        .replace(/,/g, ".")
        .replace(" Ft", "");

      if (!isNaN(rawValue) && rawValue !== "") {
        this.products[index].unitPrice = parseFloat(rawValue);
        this.formattedPrices[index] = rawValue;
      } else {
        this.products[index].unitPrice = 0;
      }
    },
    formatPrice(event, index) {
      const value = this.products[index].unitPrice;
      if (value !== 0) {
        this.formattedPrices[index] = this.formatPriceWithFt(value);
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
      return value.toLocaleString("en-HU");
    },

    roundToNearestFive(value) {
      return Math.round(value / 5) * 5;
    },
    calculateTotalWithVAT() {
      return this.calculateGrandTotal() + this.calculateVAT();
    },
    exportToPDF() {
      const element = document.getElementById("element-to-convert");

      const originalTransform = element.style.transform;
      const originalTransformOrigin = element.style.transformOrigin;

      const tableCells = document.querySelectorAll("table td");
      const tableCellsTh = document.querySelectorAll("table th");
      const tableInputs = document.querySelectorAll("table input");

      const originalPadding = [];
      const originalPaddingTh = [];
      const originalInputPadding = [];

      tableCells.forEach((cell, index) => {
        originalPadding[index] = cell.style.padding;
        cell.style.padding = "0px 5px 12px 5px";
      });

      tableCellsTh.forEach((cell, index) => {
        originalPaddingTh[index] = cell.style.padding;
        cell.style.padding = "0px 5px 12px 5px";
      });

      tableInputs.forEach((input, index) => {
        originalInputPadding[index] = input.style.padding;
      });

      const inputSpanPairs = [];
      tableInputs.forEach((input) => {
        const value = input.value.trim();

        if (value) {
          const span = document.createElement("span");
          span.textContent = value;
          span.style.display = "inline-block";
          span.style.width = input.offsetWidth + "px";
          span.style.height = input.offsetHeight + "px";
          input.style.display = "none";
          input.parentNode.insertBefore(span, input);

          inputSpanPairs.push({ input, span });
        }
      });

      element.style.transform = "scale(0.9)";
      element.style.transformOrigin = "top center";

      const nev = document.getElementById("nev").value;
      const email = document.getElementById("email").value;
      const tel = document.getElementById("tel").value;
      const cegnev = document.getElementById("cegnev").value;
      const cim = document.getElementById("cim").value;
      const ado = document.getElementById("ado").value;

      const rightColumnData = `<p>Név: ${nev}</p><p>Email: ${email}</p><p>Telefonszám: ${tel}</p>`;
      const leftColumnData = `<p>Cégnév: ${cegnev}</p><p>Cím: ${cim}</p><p>Adószám: ${ado}</p>`;

      document.querySelector(".left-column").innerHTML = leftColumnData;
      document.querySelector(".right-column").innerHTML = rightColumnData;

      const rightC = document.querySelectorAll(".right-column p");
      const leftC = document.querySelectorAll(".left-column p");

      const originalPaddingRight = [];
      const originalPaddingLeft = [];

      rightC.forEach((cell, index) => {
        originalPaddingRight[index] = cell.style.padding;
        cell.style.padding = "0px 5px 12px 5px";
        cell.style.border = "1px solid black";
        cell.style.marginBottom = "3px";
        cell.style.borderRadius = "15px";
      });

      leftC.forEach((cell, index) => {
        originalPaddingLeft[index] = cell.style.padding;
        cell.style.padding = "0px 5px 12px 5px";
        cell.style.border = "1px solid grey";
        cell.style.marginBottom = "3px";
        cell.style.borderRadius = "15px";
      });

      html2pdf()
        .from(element)
        .set({
          margin: [0.3, 0, 0, 0],
          filename: "integram-ruha-" + Date.now() + ".pdf",
          image: { type: "jpeg", quality: 0.98 },
          html2canvas: { scale: 6 },
          jsPDF: { unit: "cm", format: "a4", orientation: "landscape" },
        })
        .save()
        .then(() => {
          tableCells.forEach((cell, index) => {
            cell.style.padding = originalPadding[index];
          });

          tableCellsTh.forEach((cell, index) => {
            cell.style.padding = originalPaddingTh[index];
          });

          tableInputs.forEach((input, index) => {
            input.style.padding = originalInputPadding[index];
          });

          inputSpanPairs.forEach(({ input, span }) => {
            input.style.display = "block";
            input.value = span.textContent;
            span.remove();
          });

          document.querySelector(".left-column").innerHTML = "";
          document.querySelector(".right-column").innerHTML = "";

          element.style.transform = originalTransform;
          element.style.transformOrigin = originalTransformOrigin;
        });
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
/* .elsotablak tbody td:nth-child(1){
  background-color: #4bb543;
} */
.custom-cols {
  grid-template-columns: 2fr 1fr; 
}

.flex-container {
  display: flex;
  justify-content: space-between;
  font-family: Helvetica;
}

.calculator-container {
  @apply flex bg-white sm:w-8/12 w-11/12 h-auto mx-auto rounded-xl sm:p-8 p-2;
  margin-top: 5vh;
  font-family: Helvetica;
}

.elsotablak td {
  border: 1px solid lightgray;
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
  border: 1px solid lightgray;
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

#osszegTabla tr td {
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

#seged td {
  height: 24px;
}

#meretTabla td {
  height: 24px;
}

thead {
  font-size: small;
}

#meretTabla tbody tr:nth-child(14) input {
  background-color: skyblue;
}

#meretTabla tbody tr:nth-child(14) td {
  background-color: skyblue;
}

#meretTabla tbody tr:nth-child(15) input {
  background-color: lightgray;
}

#meretTabla tbody tr:nth-child(15) td {
  background-color: lightgray;
}

#kisMeretTabla tr:nth-child(1) td {
  background-color: skyblue;
}

#kisMeretTabla tr:nth-child(2) td {
  background-color: lightgray;
}

#kisMeretTabla td {
  border: 1px solid black;
  border-radius: 5px;
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
