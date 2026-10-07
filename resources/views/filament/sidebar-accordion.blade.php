<script>
    document.addEventListener('alpine:init', () => {
        const sidebar = window.Alpine.store('sidebar')
        const toggle = sidebar.toggleCollapsedGroup.bind(sidebar)

        sidebar.toggleCollapsedGroup = (group) => {
            const groups = Array.from(document.querySelectorAll('.fi-main-sidebar .fi-sidebar-group'))
                .map((element) => element.dataset.groupLabel)
                .filter(Boolean)

            const isOpening = sidebar.collapsedGroups.includes(group)

            toggle(group)

            if (isOpening) {
                sidebar.collapsedGroups = groups.filter((label) => label !== group)
            }
        }
    })
</script>
