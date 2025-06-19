// State
let transactions = [];

// Elements
const addIncomeBtn = document.getElementById('add-income-btn');
const addExpenseBtn = document.getElementById('add-expense-btn');
const formContainer = document.getElementById('form-container');
const formTitle = document.getElementById('form-title');
const amountInput = document.getElementById('amount');
const descriptionInput = document.getElementById('description');
const submitBtn = document.getElementById('submit-btn');
const cancelBtn = document.getElementById('cancel-btn');
const totalIncomeEl = document.getElementById('total-income');
const totalExpenseEl = document.getElementById('total-expense');
const balanceEl = document.getElementById('balance');
const transactionListEl = document.getElementById('transaction-list');
const generateReportBtn = document.getElementById('generate-report-btn');
const reportOutputEl = document.getElementById('report-output');

// Show form
const showForm = (type) => {
  formTitle.innerText = type === 'income' ? 'Add Income' : 'Add Expense';
  formContainer.classList.remove('hidden');
  submitBtn.setAttribute('data-type', type);
};

// Hide form
const hideForm = () => {
  formContainer.classList.add('hidden');
  amountInput.value = '';
  descriptionInput.value = '';
};

// Update summary
const updateSummary = () => {
  const income = transactions
    .filter((t) => t.type === 'income')
    .reduce((sum, t) => sum + t.amount, 0);
  const expense = transactions
    .filter((t) => t.type === 'expense')
    .reduce((sum, t) => sum + t.amount, 0);

  totalIncomeEl.innerText = income;
  totalExpenseEl.innerText = expense;
  balanceEl.innerText = income - expense;
};

// Update transaction list
const updateTransactions = () => {
  transactionListEl.innerHTML = '';
  transactions.forEach((transaction, index) => {
    const li = document.createElement('li');
    li.classList.add(transaction.type);
    li.innerHTML = `
      ${transaction.description} - $${transaction.amount}
      <button onclick="deleteTransaction(${index})">X</button>
    `;
    transactionListEl.appendChild(li);
  });
};

// Add transaction
const addTransaction = (type, amount, description) => {
  transactions.push({ type, amount, description });
  updateSummary();
  updateTransactions();
};

// Delete transaction
const deleteTransaction = (index) => {
  transactions.splice(index, 1);
  updateSummary();
  updateTransactions();
};

// Generate report
const generateReport = () => {
  const incomeTransactions = transactions.filter((t) => t.type === 'income');
  const expenseTransactions = transactions.filter((t) => t.type === 'expense');
  const totalIncome = incomeTransactions.reduce((sum, t) => sum + t.amount, 0);
  const totalExpense = expenseTransactions.reduce((sum, t) => sum + t.amount, 0);

  reportOutputEl.innerText = `
    Total Income: $${totalIncome}
    Total Expense: $${totalExpense}
    Remaining Balance: $${totalIncome - totalExpense}
    
    Detailed Transactions:
    Income:
    ${incomeTransactions
      .map((t) => `- ${t.description}: $${t.amount}`)
      .join('\n')}
    Expenses:
    ${expenseTransactions
      .map((t) => `- ${t.description}: $${t.amount}`)
      .join('\n')}
  `;
};

// Event listeners
addIncomeBtn.addEventListener('click', () => showForm('income'));
addExpenseBtn.addEventListener('click', () => showForm('expense'));
cancelBtn.addEventListener('click', hideForm);
submitBtn.addEventListener('click', () => {
  const type = submitBtn.getAttribute('data-type');
  const amount = parseFloat(amountInput.value);
  const description = descriptionInput.value;

  if (amount && description) {
    addTransaction(type, amount, description);
    hideForm();
  }
});
generateReportBtn.addEventListener('click', generateReport);
