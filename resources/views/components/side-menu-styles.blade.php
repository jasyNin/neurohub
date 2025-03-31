@push('styles')
<style>
.side-menu {
    position: sticky;
    top: 0;
    display: flex;
    flex-direction: column;
    height: calc(100vh - 80px);
    padding-left: 0;
    margin-top: 80px;
}

.menu-section {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.menu-item {
    padding: 8px 12px;
    border-radius: 8px;
    transition: all 0.3s ease;
    margin-left: 0;
}

.menu-item:hover {
    background-color: #F8F9FA;
}

.menu-item.active {
    background-color: #F0F0F0;
}

.menu-item a {
    color: #272727;
    font-size: 15px;
    font-weight: 500;
}

.menu-item svg {
    color: #272727;
    opacity: 0.8;
}

.menu-item:hover svg {
    opacity: 1;
}

.menu-section:last-child {
    margin-top: auto;
    padding-top: 24px;
    border-top: 1px solid #F0F0F0;
}
</style>
@endpush 