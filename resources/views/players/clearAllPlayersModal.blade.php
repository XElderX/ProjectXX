                            <!-- Modal -->
                        <div class="modal fade" id="clear" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Player Deletion comfirmation</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are your sure to delete ALL Players? It can't be undone!!
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="button" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="button">
                                            <a href="{{ route('player.clear', ['all']) }}" class="text-sm  dark:text-gray-500">Delete all players!!!</a>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>