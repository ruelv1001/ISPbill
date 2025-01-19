<?php
namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\AuthHelper;
class Table extends Component
{
    public $headers;
    public $data;
    public $title;
    public $dropdown;
    public $actions;
    public $tablename;
    public $addbtn;
    public $filters;
    public $searchField;
    public $tableCheckedbox;
    public $dltAllbtn;
    public $itemName;
    public $message;
    public $filterRoute;
    public $isDropdown;
    public $isDropdownOptions;

    /**
     * Create a new component instance.
     *
     * @param array $headers
     * @param LengthAwarePaginator $data
     * @param string $title
     * @param array $dropdown
     * @param array $actions
     * @param string $tablename
     * @param array $addbtn
     * @param array $filters
     * @param bool $searchField
     * @param bool $tableCheckedbox
     * @param array $dltAllbtn
     * @param string $itemName
     * @param array $message
     * @param string|null $filterRoute
     * @param bool|null $isDropdown
     * @param array|null $isDropdownOptions
     */
    public function __construct(
        array $headers,
        $data,  // Change from LengthAwarePaginator to a more flexible type
        string $title = '',
        array $dropdown = [],
        array $actions = [],
        string $tablename,
        array $addbtn = [],
        array $filters = [],
        $searchField = false,
        $tableCheckedbox = true,
        $dltAllbtn = [],
        $itemName = '',
        $message = [],
        $filterRoute = null,
        $isDropdown = null,
        $isDropdownOptions = null
    ) {
        $this->tablename = $tablename;
        $this->title = $title;
        $this->headers = $headers;
        $this->data = $data;
        $this->dropdown = $dropdown;
        $this->actions = $actions;
        $this->addbtn = $addbtn;
        $this->filters = $filters;
        $this->searchField = $searchField;
        $this->tableCheckedbox = $tableCheckedbox;
        $this->dltAllbtn = $dltAllbtn;
        $this->itemName = $itemName;
        $this->message = $message;
        $this->filterRoute = $filterRoute;
        $this->isDropdown = $isDropdown;
        $this->isDropdownOptions = $isDropdownOptions;
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
public function render()
{
    return view('components.table', [
        'data' => $this->data,
    ]);
}
}

