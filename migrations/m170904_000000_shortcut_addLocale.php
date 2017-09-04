<?php
namespace Craft;
/**
 * The class name is the UTC timestamp in the format of mYYMMDD_HHMMSS_pluginHandle_migrationName
 */
class m170904_000000_shortcut_addLocale extends BaseMigration
{
    /**
     * Any migration code in here is wrapped inside of a transaction.
     *
     * @return bool
     */
    public
    function safeUp ()
    {
        // specify columns and AttributeType
        $newColumns = [
            'locale' => [
                'column'  => ColumnType::Locale,
                'default' => null,
                'null'    => true,
            ],
        ];
        $this->_addColumnsAfter("shortcut", $newColumns, "elementType");

        // Return true and let craft know its done
        return true;
    }

    private
    function _addColumnsAfter ($tableName, $newColumns, $afterColumnHandle)
    {
        // this is a foreach loop, enough said
        foreach ($newColumns as $columnName => $columnType) {
            // check if the column does NOT exist
            if ( !craft()->db->columnExists($tableName, $columnName) ) {
                $config = [
                    'null' => false,
                ];
                if ( is_array($columnType) ) {
                    $config = array_merge($config, $columnType);
                }
                else {
                    $config['column'] = $columnType;
                }

                $this->addColumnAfter($tableName, $columnName, $config, $afterColumnHandle);
                // Log that we created the new column
                ShortcutPlugin::log("Created the `$columnName` in the `$tableName` table.", LogLevel::Info, true);
            }
            // If the column already exists in the table
            else {
                // Tell craft that we couldn't create the column as it alredy exists.
                ShortcutPlugin::log("Column `$columnName` already exists in the `$tableName` table.", LogLevel::Info, true);
            }
        }
    }
}