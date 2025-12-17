<template>
  <div class="flex h-screen bg-gray-100 font-sans">
    <Sidebar />

    <!-- Main content area -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <Header />

      <!-- Main content -->
      <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
          <!-- Stat Cards -->
          <StatCards />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
          <!-- Financial Overview Chart -->
          <FinancialOverviewChart />

          <!-- Operational Costs Chart -->
          <OperationalCostsChart />
        </div>

        <!-- Recent Activity -->
        <RecentActivity />
      </main>
    </div>
  </div>
</template>

<script setup>
import Sidebar from './Sidebar.vue';
import Header from './Header.vue';
import StatCards from './StatCards.vue';
import FinancialOverviewChart from './FinancialOverviewChart.vue';
import OperationalCostsChart from './OperationalCostsChart.vue';
import RecentActivity from './RecentActivity.vue';
// I will add the necessary script for the components later.
</script>
