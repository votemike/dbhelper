<?php

namespace Votemike\Dbhelper;

use App\Http\Controllers\Controller;
use DB;

class DbHelperController extends Controller
{

    /**
     * @return Response
     */
    public function showReport()
    {
        return view('dbhelper::report', ['tables' => $this->getTableSuggestions()]);
    }

    public function getTableSuggestions($table = null)
    {
        $tableCollection = new TableCollection();
        $results = $this->getDatabaseColumns($table);
        foreach ($results as $result) {
            $tableCollection->addColumnToTable($result->TABLE_NAME, $result->COLUMN_NAME, $result->COLUMN_TYPE,
                $result->DATA_TYPE);
        }
        $tableCollection->populateTableColumnsWithLongestValue();
        $tableCollection->populateTableColumnsWithSuggestedType();

        return $tableCollection->getTablesForDisplay();
    }

    private function getDatabaseColumns($table = null)
    {
        //return DB::table('information_schema.columns')->where('TABLE_SCHEMA', '!=', 'information_schema')->get(); //All columns in mysql
        if (is_null($table)) {
            return DB::table('information_schema.columns')->where('TABLE_SCHEMA',
                DB::connection()->getDatabaseName())->get(); //All columns in current DB
        }
        return DB::table('information_schema.columns')->where('TABLE_SCHEMA',
            DB::connection()->getDatabaseName())->where('TABLE_NAME', $table)->get(); //All columns in table
    }
}