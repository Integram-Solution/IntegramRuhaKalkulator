<template>
  <div class="calculator-container flex flex-col">
    <div class="grid form-grid lg:grid-cols-3 md:grid-cols-1 grid-cols-1">
      <div class="flex items-center justify-center order-1 lg:order-3">
        <img
          class="lg:w-11/12 w-4/12"
          src="/public/IHS.png"
          alt=""
        />
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 order-2 lg:order-1">
        <div>
          <div>
            <label for="cegnev">Cégnév</label><br />
            <input
              class="border w-full rounded-xl"
              type="text"
              name="cegnev"
              id="cegnev"
              v-model="form.cegnev"
              :class="{ 'input-error': errors.cegnev }"
              @input="checkInputs"
              @blur="validateInput('cegnev')"
            />
          </div>
          <div>
            <label for="cim">Cím</label><br />
            <input
              class="border w-full rounded-xl"
              type="text"
              name="cim"
              id="cim"
              v-model="form.cim"
              :class="{ 'input-error': errors.cim }"
              @input="checkInputs"
              @blur="validateInput('cim')"
            />
          </div>
          <div>
            <label for="ado">Adószám</label><br />
            <input
              class="border w-full rounded-xl"
              type="text"
              name="ado"
              id="ado"
              v-model="form.ado"
              :class="{ 'input-error': errors.ado }"
              @input="checkInputs"
              @blur="validateInput('ado')"
            />
          </div>
        </div>
        <div>
          <div>
            <label for="nev">Név</label><br />
            <input
              class="border lg:w-9/12 w-full rounded-xl"
              type="text"
              name="nev"
              id="nev"
              v-model="form.nev"
              :class="{ 'input-error': errors.nev }"
              @input="checkInputs"
              @blur="validateInput('nev')"
            />
          </div>
          <div>
            <label for="tel">Telefonszám</label><br />
            <input
              class="border lg:w-9/12 w-full rounded-xl"
              type="tel"
              name="tel"
              id="tel"
              v-model="form.tel"
              :class="{ 'input-error': errors.tel }"
              @input="checkInputs"
              @blur="validateInput('tel')"
            />
          </div>
          <div>
            <label for="email">E-mail</label><br />
            <input
              class="border lg:w-9/12 w-full rounded-xl"
              type="email"
              name="email"
              id="email"
              v-model="form.email"
              :class="{ 'input-error': errors.email }"
              @input="checkInputs"
              @blur="validateInput('email')"
            />
          </div>
        </div>
      </div>
    </div>

    <div class="mt-2">
      <input
        class="mr-2"
        type="checkbox"
        name="megjegyzesElso"
        id="megjegyzesElso"
        checked
      />
      <label class="text-xs" for="megjegyzesElso">Első megjegyzés</label><br />
      <input
        class="mr-2"
        type="checkbox"
        name="megjegyzesMasodik"
        id="megjegyzesMasodik"
        checked
      />
      <label class="text-xs" for="megjegyzesMasodik">Második megjegyzés</label>
    </div>

    <div id="element-to-convert">
      <div id="form-data" class="grid grid-cols-3">
        <div class="left-column">
          <!-- Bal oldali adatok -->
        </div>
        <div class="right-column">
          <!-- Jobb oldali adatok -->
        </div>
        <div class="kep flex justify-content-center align-items-center">
          <!-- kep -->
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
                    :readonly="!inputsFilled"
                    @focus="highlightEmptyInputs"
                  />
                </td>
                <td>
                  <input
                    type="text"
                    v-model="product.unitPrice"
                    @input="updatePrice($event, index)"
                    class="table-input"
                    :readonly="!inputsFilled"
                    @focus="highlightEmptyInputs"
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
              <td class="w-44">
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
                      :readonly="!inputsFilled"
                      @focus="highlightEmptyInputs"
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
                      :readonly="!inputsFilled"
                      @focus="highlightEmptyInputs"
                      min="0"
                    />
                  </td>
                  <td>
                    <input
                      class="table-input"
                      type="number"
                      v-model="sizes.m"
                      :readonly="!inputsFilled"
                      @focus="highlightEmptyInputs"
                      min="0"
                    />
                  </td>
                  <td>
                    <input
                      class="table-input"
                      type="number"
                      v-model="sizes.l"
                      :readonly="!inputsFilled"
                      @focus="highlightEmptyInputs"
                      min="0"
                    />
                  </td>
                  <td>
                    <input
                      class="table-input"
                      type="number"
                      v-model="sizes.xl"
                      :readonly="!inputsFilled"
                      @focus="highlightEmptyInputs"
                      min="0"
                    />
                  </td>
                  <td>
                    <input
                      class="table-input"
                      type="number"
                      v-model="sizes.xxl"
                      :readonly="!inputsFilled"
                      @focus="highlightEmptyInputs"
                      min="0"
                    />
                  </td>
                  <td>
                    <input
                      class="table-input"
                      type="number"
                      v-model="sizes.xxxl"
                      :readonly="!inputsFilled"
                      @focus="highlightEmptyInputs"
                      min="0"
                    />
                  </td>
                  <td>
                    <input
                      class="table-input"
                      type="number"
                      v-model="sizes.xxxxl"
                      :readonly="!inputsFilled"
                      @focus="highlightEmptyInputs"
                      min="0"
                    />
                  </td>
                  <td>
                    <input
                      class="table-input"
                      type="number"
                      v-model="sizes.xxxxxl"
                      :readonly="!inputsFilled"
                      @focus="highlightEmptyInputs"
                      min="0"
                    />
                  </td>
                  <td>
                    <input
                      class="table-input"
                      type="number"
                      v-model="sizes.xxxxxxl"
                      :readonly="!inputsFilled"
                      @focus="highlightEmptyInputs"
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
      form: {
        cegnev: "",
        cim: "",
        ado: "",
        nev: "",
        tel: "",
        email: "",
      },
      inputsFilled: false,
      errors: {
        cegnev: false,
        cim: false,
        ado: false,
        nev: false,
        tel: false,
        email: false,
      },
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
    checkInputs() {
      this.inputsFilled =
        this.form.cegnev !== "" &&
        this.form.cim !== "" &&
        this.form.ado !== "" &&
        this.form.nev !== "" &&
        this.form.tel !== "" &&
        this.form.email !== "";
    },
    validateInput(field) {
      if (!this.form[field]) {
        this.errors[field] = true;
      } else {
        this.errors[field] = false;
      }
      this.checkInputs();
    },
    clearError(field) {
      this.errors[field] = false;
    },
    highlightEmptyInputs() {
      Object.keys(this.form).forEach((field) => {
        if (!this.form[field]) {
          this.errors[field] = true;
        }
      });
    },
    clearErrors() {
      this.errors.cegnev = false;
      this.errors.cim = false;
      this.errors.ado = false;
      this.errors.nev = false;
      this.errors.tel = false;
      this.errors.email = false;
    },
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

      element.style.transform = "scale(0.8)";
      element.style.transformOrigin = "top center";

      const nev = document.getElementById("nev").value;
      const email = document.getElementById("email").value;
      const tel = document.getElementById("tel").value;
      const cegnev = document.getElementById("cegnev").value;
      const cim = document.getElementById("cim").value;
      const ado = document.getElementById("ado").value;

      const rightColumnData = `
  <p>Név:<br><span class="full-width">${nev}</span></p>
  <p>Email:<br><span class="full-width">${email}</span></p>
  <p>Telefonszám:<br><span class="full-width">${tel}</span></p>
`;
      const leftColumnData = `
  <p>Cégnév:<br><span class="full-width">${cegnev}</span></p>
  <p>Cím:<br><span class="full-width">${cim}</span></p>
  <p>Adószám:<br><span class="full-width">${ado}</span></p>
`;

      const kepDiv = document.querySelector(".kep");
      const logo = document.createElement("img");
      logo.src = "/public/IHS.png";
      logo.alt = "Logo";
      logo.style.width = "100%";
      logo.style.maxWidth = "200px";
      logo.style.margin = "auto";
      kepDiv.appendChild(logo);

      document.querySelector(".left-column").innerHTML = leftColumnData;
      document.querySelector(".right-column").innerHTML = rightColumnData;

      const rightC = document.querySelectorAll(".right-column span");
      const leftC = document.querySelectorAll(".left-column span");

      rightC.forEach((cell) => {
        cell.style.padding = "0px 5px 15px 5px";
        cell.style.border = "1px solid lightgrey";
        cell.style.borderRadius = "15px";
        cell.style.display = "block";
        cell.style.width = "85%";
        cell.style.marginTop = "6px";
        cell.style.minHeight = "40px";
      });

      leftC.forEach((cell) => {
        cell.style.padding = "0px 5px 15px 5px";
        cell.style.border = "1px solid lightgrey";
        cell.style.borderRadius = "15px";
        cell.style.display = "block";
        cell.style.width = "100%";
        cell.style.marginTop = "6px";
        cell.style.minHeight = "40px";
      });

      const rightCP = document.querySelectorAll(".right-column p ");
      const leftCP = document.querySelectorAll(".left-column p");

      rightCP.forEach((cell) => {
        cell.style.marginBottom = "3px";
        cell.style.paddingLeft = "20px";
      });

      leftCP.forEach((cell) => {
        cell.style.marginBottom = "3px";
      });

      const inputs = document.querySelectorAll(".masodiktablak span");

      const originalPaddingInputs = [];

      inputs.forEach((input, index) => {
        originalPaddingInputs[index] = input.style.paddingRight;

        const value = parseInt(input.textContent, 10);

        if (value > 99) {
          input.style.paddingRight = "23px";
        } else if (value > 9) {
          input.style.paddingRight = "15px";
        } else {
          input.style.paddingRight = "0px";
        }
      });
      const formData = document.getElementById("form-data");
      formData.style.gridTemplateColumns = "2fr 2fr 1fr";

      const originalMaxHeight = element.style.maxHeight;
      element.style.maxHeight = "20.5cm";
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

          inputs.forEach((input, index) => {
            input.style.padding = originalPaddingInputs[index];
          });

          document.querySelector(".left-column").innerHTML = "";
          document.querySelector(".right-column").innerHTML = "";

          kepDiv.removeChild(logo);

          element.style.maxHeight = originalMaxHeight;

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
.input-error {
  border: 2px solid #e3342f;
  box-shadow: 0 0 5px 2px rgba(227, 52, 47, 0.2);
}

#form-data {
  font-family: Helvetica;
}

.custom-cols {
  grid-template-columns: 2fr 1fr;
}

@media (min-width: 1024px) {
  .form-grid {
    grid-template-columns: 5fr 1fr;
  }
}

@media (max-width: 1024px) {
  .custom-cols {
    grid-template-columns: 1fr;
  }
}

.calculator-container {
  @apply flex bg-white sm:w-8/12 w-11/12 h-auto mx-auto rounded-xl sm:p-8 p-2;
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
