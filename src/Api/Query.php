<?php

namespace Zoho\Crm\Api;

use DateTime;
use Zoho\Crm\Connection;
use Zoho\Crm\Api\UrlParameters;
use Zoho\Crm\Exception\InvalidQueryException;
use Zoho\Crm\Entities\AbstractEntity;
use Zoho\Crm\Entities\Collection;

class Query
{
    protected $connection;

    protected $format;

    protected $module;

    protected $method;

    protected $parameters;

    protected $paginator;

    protected $limit;

    protected $max_modification_date;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->parameters = new UrlParameters;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function format($format)
    {
        $this->format = $format;

        return $this;
    }

    public function getModule()
    {
        return $this->module;
    }

    public function module($module)
    {
        $this->module = $module;

        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function method($method)
    {
        $this->method = $method;

        return $this;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getParameter($key)
    {
        return $this->parameters[$key];
    }

    public function hasParameter($key)
    {
        return $this->parameters->contains($key);
    }

    public function resetParameters($parameters = [])
    {
        if (! $parameters instanceof UrlParameters) {
            $parameters = new UrlParameters($parameters);
        }

        $this->parameters = $parameters;

        return $this;
    }

    public function param($key, $value = null)
    {
        $this->parameters->set($key, $value);

        return $this;
    }

    public function params($parameters)
    {
        foreach ($parameters as $key => $value) {
            $this->param($key, $value);
        }

        return $this;
    }

    public function orderBy($column, $order = 'asc')
    {
        return $this->params([
            'sortColumnString' => $column,
            'sortOrderString' => $order
        ]);
    }

    public function select(array $columns)
    {
        $selection = $this->module . '(' . implode(',', $columns) . ')';

        return $this->param('selectColumns', $selection);
    }

    public function getSelectedColumns()
    {
        $selection = $this->parameters->get('selectColumns');

        if ($selection === null) {
            return [];
        }

        // Remove the surrounding characters
        $selection = rtrim(ltrim($selection, $this->module.'('), ')');

        // Split the string on coma and trim the column names
        return array_map('trim', explode(',', $selection));
    }

    public function hasSelect($column)
    {
        return in_array($column, $this->getSelectedColumns());
    }

    public function modifiedAfter($date)
    {
        if ($date === null) {
            $this->parameters->remove('lastModifiedTime');
            return $this;
        }

        if (! ($date instanceof DateTime) && is_string($date)) {
            $date = new DateTime($date);
        }

        return $this->param('lastModifiedTime', $date);
    }

    public function modifiedBefore($date)
    {
        if (! ($date instanceof DateTime) && is_string($date)) {
            $date = new DateTime($date);
        }

        $this->max_modification_date = $date;

        return $this;
    }

    public function getMaxModificationDate()
    {
        return $this->max_modification_date;
    }

    public function hasMaxModificationDate()
    {
        return isset($this->max_modification_date);
    }

    public function limit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function hasLimit()
    {
        return isset($this->limit);
    }

    public function paginate()
    {
        return new QueryPaginator($this);
    }

    public function paginated($paginated = true)
    {
        $this->paginator = $paginated ? $this->paginate() : null;

        return $this;
    }

    public function isPaginated()
    {
        return isset($this->paginator);
    }

    public function getPaginator()
    {
        return $this->paginator;
    }

    public function buildUri()
    {
        return "{$this->format}/{$this->module}/{$this->method}?{$this->parameters}";
    }

    public function isMalformed()
    {
        return is_null($this->format) || is_null($this->module) || is_null($this->method);
    }

    public function validate()
    {
        // Very basic validation: just check that required parts are present.
        if ($this->isMalformed()) {
            throw new InvalidQueryException($this, 'malformed URI.');
        }

        // "Modified Time" column has to be be present in the results
        // for "modifiedBefore()" constraint to work properly.
        $selected_columns = $this->getSelectedColumns();
        $modified_date_is_missing = ! empty($selected_columns) && ! in_array('Modified Time', $selected_columns);

        if ($this->hasMaxModificationDate() && $modified_date_is_missing) {
            $message = '"Modified Time" column is required with "modifiedBefore()" constraint.';
            throw new InvalidQueryException($this, $message);
        }
    }

    public function isValid()
    {
        try {
            $this->validate();
        } catch (InvalidQueryException $e) {
            return false;
        }

        return true;
    }

    public function execute()
    {
        return $this->connection->executeQuery($this);
    }

    public function get()
    {
        return $this->connection->getQueryResults($this);
    }

    public function copy()
    {
        return clone $this;
    }
}
