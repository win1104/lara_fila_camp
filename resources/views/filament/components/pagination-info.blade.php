<div class="flex items-center justify-between">
    <div>
        @if ($this->getTableRecords()->hasPages())
            <x-filament::pagination.overview
                :first-item="$this->getTableRecords()->firstItem()"
                :last-item="$this->getTableRecords()->lastItem()"
                :total="$this->getTableRecords()->total()"
            />
        @endif
    </div>
    <div>
        @if ($this->getTableRecords()->hasPages())
            <x-filament::pagination.simple
                :paginator="$this->getTableRecords()"
                :page-options="$this->getTable()->getPaginationPageOptions()"
            />
        @endif
    </div>
</div>