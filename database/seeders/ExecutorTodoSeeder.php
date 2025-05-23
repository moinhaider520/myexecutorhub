<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExecutorTodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert Standard Executor stages
        $standardStages = [
            ['name' => 'Stage 1: Immediately After Death', 'description' => 'Immediate actions required after death', 'order' => 1, 'type' => 'standard'],
            ['name' => 'Stage 2: Legal Authority', 'description' => 'Obtaining legal authority to act', 'order' => 2, 'type' => 'standard'],
            ['name' => 'Stage 3: Notify and Collect', 'description' => 'Notifying relevant parties and collecting information', 'order' => 3, 'type' => 'standard'],
            ['name' => 'Stage 4: Pay Debts and Liabilities', 'description' => 'Settling outstanding debts and liabilities', 'order' => 4, 'type' => 'standard'],
            ['name' => 'Stage 5: Distribute the Estate', 'description' => 'Final distribution of the estate', 'order' => 5, 'type' => 'standard'],
        ];

        // Insert Advanced Executor stages
        $advancedStages = [
            ['name' => 'A. Immediate Legal & Personal Tasks', 'description' => 'Comprehensive immediate actions for complex estates', 'order' => 1, 'type' => 'advanced'],
            ['name' => 'B. Estate Valuation & Notifications', 'description' => 'Complete asset valuation and notification process', 'order' => 2, 'type' => 'advanced'],
            ['name' => 'C. Inheritance Tax & Probate', 'description' => 'Handle inheritance tax and probate applications', 'order' => 3, 'type' => 'advanced'],
            ['name' => 'D. Estate Administration', 'description' => 'Manage complex estate administration tasks', 'order' => 4, 'type' => 'advanced'],
            ['name' => 'E. Final Accounting & Distribution', 'description' => 'Complete accounting and distribution process', 'order' => 5, 'type' => 'advanced'],
            ['name' => 'F. Final Compliance', 'description' => 'Final compliance and record keeping', 'order' => 6, 'type' => 'advanced'],
        ];

        $allStages = array_merge($standardStages, $advancedStages);

        foreach ($allStages as $stage) {
            $stageId = DB::table('executor_todo_stages')->insertGetId([
                'name' => $stage['name'],
                'description' => $stage['description'],
                'order' => $stage['order'],
                'type' => $stage['type'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert todo items for each stage
            $this->insertTodoItems($stageId, $stage['order'], $stage['type']);
        }
    }

    private function insertTodoItems($stageId, $stageOrder, $type)
    {
        $todoItems = [];

        if ($type === 'standard') {
            switch ($stageOrder) {
                case 1: // Stage 1: Immediately After Death
                    $todoItems = [
                        ['title' => 'Register the death and get certified copies of the death certificate', 'order' => 1],
                        ['title' => 'Locate the original Will', 'order' => 2],
                        ['title' => 'Secure property, pets, and valuables', 'order' => 3],
                        ['title' => 'Arrange the funeral', 'order' => 4],
                        ['title' => 'Inform close family and friends', 'order' => 5],
                    ];
                    break;

                case 2: // Stage 2: Legal Authority
                    $todoItems = [
                        ['title' => 'Check if probate is required', 'order' => 1],
                        ['title' => 'Apply for the Grant of Probate (if needed)', 'order' => 2],
                        ['title' => 'Upload documents to Executor Hub for safekeeping', 'order' => 3],
                    ];
                    break;

                case 3: // Stage 3: Notify and Collect
                    $todoItems = [
                        ['title' => 'Notify banks, insurers, pension providers, etc.', 'order' => 1],
                        ['title' => 'Redirect post', 'order' => 2],
                        ['title' => 'Start building a list of assets and debts', 'order' => 3],
                    ];
                    break;

                case 4: // Stage 4: Pay Debts and Liabilities
                    $todoItems = [
                        ['title' => 'Use funds from the estate to settle outstanding bills and debts', 'order' => 1],
                        ['title' => 'Keep records of all payments', 'order' => 2],
                    ];
                    break;

                case 5: // Stage 5: Distribute the Estate
                    $todoItems = [
                        ['title' => 'Prepare a basic estate account (money in, money out)', 'order' => 1],
                    ];
                    break;
            }
        } else { // Advanced type
            switch ($stageOrder) {
                case 1: // A. Immediate Legal & Personal Tasks
                    $todoItems = [
                        ['title' => 'Register the death and obtain 5–10 certified death certificates', 'order' => 1],
                        ['title' => 'Locate and read the Will (check for trust clauses, guardianship, etc.)', 'order' => 2],
                        ['title' => 'Secure all property, assets, pets, and cancel insurance policies', 'order' => 3],
                        ['title' => 'Notify key parties: employer, GP, care providers, etc.', 'order' => 4],
                        ['title' => 'Arrange funeral (check for pre-paid plan)', 'order' => 5],
                    ];
                    break;

                case 2: // B. Estate Valuation & Notifications
                    $todoItems = [
                        ['title' => 'Inform HMRC (use "Tell Us Once" or direct contact)', 'order' => 1],
                        ['title' => 'Notify all asset holders and creditors', 'order' => 2],
                        ['title' => 'Value property (get estate agent or RICS valuations)', 'order' => 3],
                        ['title' => 'Value bank accounts and savings', 'order' => 4],
                        ['title' => 'Value shares, pensions, life insurance', 'order' => 5],
                        ['title' => 'Value personal items of significant value', 'order' => 6],
                        ['title' => 'Identify and list all liabilities and recurring bills', 'order' => 7],
                        ['title' => 'Check for foreign assets or digital assets (cryptocurrency, online accounts)', 'order' => 8],
                        ['title' => 'Redirect post', 'order' => 9],
                    ];
                    break;

                case 3: // C. Inheritance Tax & Probate
                    $todoItems = [
                        ['title' => 'Determine if IHT applies (above threshold, gifts in 7 years, trusts)', 'order' => 1],
                        ['title' => 'Complete IHT forms (IHT205/IHT400)', 'order' => 2],
                        ['title' => 'Pay any IHT due (from the estate or executor\'s funds if necessary)', 'order' => 3],
                        ['title' => 'Apply for Grant of Probate (attach Will and IHT forms)', 'order' => 4],
                    ];
                    break;

                case 4: // D. Estate Administration
                    $todoItems = [
                        ['title' => 'Collect in assets (liquidate or transfer where necessary)', 'order' => 1],
                        ['title' => 'Sell property if required (involve estate agents or clearance firms)', 'order' => 2],
                        ['title' => 'Close accounts, cancel utilities, and terminate tenancies', 'order' => 3],
                        ['title' => 'Settle all outstanding debts', 'order' => 4],
                        ['title' => 'Continue paying insurances where needed during administration', 'order' => 5],
                    ];
                    break;

                case 5: // E. Final Accounting & Distribution
                    $todoItems = [
                        ['title' => 'Keep full records of all transactions', 'order' => 1],
                        ['title' => 'Prepare and share full estate accounts with beneficiaries', 'order' => 2],
                        ['title' => 'Get written approval before distributing', 'order' => 3],
                        ['title' => 'Distribute legacies, residual gifts, and personal belongings', 'order' => 4],
                        ['title' => 'Transfer ownership of property, shares, or vehicles', 'order' => 5],
                    ];
                    break;

                case 6: // F. Final Compliance
                    $todoItems = [
                        ['title' => 'Submit final tax return for the deceased (if required)', 'order' => 1],
                        ['title' => 'Report income earned during estate administration', 'order' => 2],
                        ['title' => 'Retain all paperwork for at least 12 years', 'order' => 3],
                        ['title' => 'Inform HMRC when administration is complete', 'order' => 4],
                        ['title' => 'Upload all documents to Executor Hub and archive the file', 'order' => 5],
                    ];
                    break;
            }
        }

        foreach ($todoItems as $item) {
            DB::table('executor_todo_items')->insert([
                'stage_id' => $stageId,
                'title' => $item['title'],
                'order' => $item['order'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}